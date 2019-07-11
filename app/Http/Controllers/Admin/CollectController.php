<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\Collect;
use App\Library\OrderNumber;
use App\Turnover;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CollectController extends Controller
{
    public $types;
    public $interest;
    public $items;

    public function __construct()
    {
        parent::__construct();
        $this->types = Action::getCollect();
        $this->items = [
            'id' => '#ID',
            'order' => '单号',
            'name' => '用户',
            'is_online' => '类型',
            'total' => '总额',
            'data' => '补差金额',
            'created_at' => '日期',
            'action' => '操作'];
    }

    public function display($id = null)
    {
        $user = null;
        if ($id) {
            $user = User::query()->where('id', $id)->first();
            if (is_null($user)) return redirect()->route('admin.home');
            $c = Collect::query()->where('user_id', $id);
        } else {
            $c = new Collect();
        }
        $results = $c->orderBy('id', 'desc')->Paginate($this->paginate);
        return $this->render($results, $user);
    }

    public function order($order = null)
    {
        if ($order) {
            $results = Collect::query()->where('order', $order)->Paginate(1);  //
            return $this->render($results, null, $order);
        }
        return redirect()->route('admin.home');
    }

    protected function render($results, $user = null, $order = null)
    {
        $items = $this->items;
        $types = $this->types;
        return view('admin.pages.collect.index', compact('items', 'results', 'types', 'user', 'order'));
    }

    /**
     * Show the form for creating a new Collect.
     * @param null $id user_id
     * @return Factory|View
     */
    public function createFrom($id = null)
    {
        $types = $this->types;
        if ($id) {
            $user = User::query()->find($id);
            if (is_null($user)) return redirect()->route('admin');
            return view('admin.pages.collect.edit', compact('user', 'types'));
        } else {
            return view('admin.pages.collect.edit', compact('types'));
        }
    }

    /**
     * Show the form for update a Collect.
     *
     * @param null $id collect_id
     * @return Factory|View
     */
    public function updateForm($id = null)
    {
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $types = $this->types;
        $results = Collect::query()->find($id);
        return view('admin.pages.collect.edit', compact('results', 'types'));
    }

    public function updateFromTurnoverForm($id = null){
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $types = $this->types;
        $t = Turnover::query()->find($id);
        if (is_null($t->collect)){
            $results = Collect::query()->create([
                'total' => 0,
                'order' => OrderNumber::collect(),
                'is_online' => $t->type_id,
                'turn_id' => $t->id,
                'user_id' => $t->user_id
            ]);
        } else {
            $results = Collect::query()->find($t->collect->id);
        }
        return view('admin.pages.collect.edit', compact('results', 'types'));
    }

    /**
     * create a Collect
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'is_online' => 'required|numeric',
            'data' => 'required|numeric|min:0.01|max:99999999999',
            'created_at' => 'required|date'
        ]);

        $data = $request->only('user_id', 'is_online', 'total');

        $action = Action::query()->find($data['is_online']);
        $d = [
            'data' => $request->input('data'),
            'user_id' => $data['user_id'],
            'type_id' => $action->id,
            'created_at' => Carbon::parse($request->input('created_at'))->toDateTimeString(),
        ];

        $d['order'] = OrderNumber::order();
        $data['order'] = OrderNumber::collect();
        $data['turn_id'] = Turnover::query()->create($d)->id;

        User::saveToUser($data['user_id'], $d['data'], $action->type->action);
        Collect::query()->create($data);

        return $request->input('method') ?
            redirect()->back()->with('toast', '创建完成') :
            redirect()->route('admin.collect')->with('toast', '创建完成');
    }


    /**
     *  method post delete a Collect
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateCollect(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'is_online' => 'numeric',
            'data' => 'numeric|min:0.01|max:99999999999',
            'created_at' => 'date'
        ]);

        $data = $request->only('is_online', 'total');

        $new = Action::query()->find($data['is_online']);
        $d = [
            'data' => $request->input('data'),
            'type_id' => $new->id,
            'created_at' => Carbon::parse($request->input('created_at'))->toDateTimeString(),
        ];

        $c = Collect::query()->find($request->input('id'));
        $t = Turnover::query()->find($c->turn_id);

        $old = Action::query()->find($t->type_id)->type->action;

        User::recoveryUser($t, $old);
        User::saveToUser($t->user_id, $d['data'], $new);

        $t->update($d);
        $c->update($data);

        Collect::query()->find($request->input('id'))->update($request->only('is_online', 'data', 'created_at'));
        return redirect($request->input('url'))->with('toast', '汇总数据完成更新');
    }

    /**
     *  method post delete a Collect
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     * @throws \Exception
     */
    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $c = Collect::query()->find($request->input('id'));
        $t = Turnover::query()->find($c->turn_id);
        if (!is_null($t)) {
            User::recoveryUser($t, Action::query()->find($t->type_id));
            $t->delete();
        }
        $c->delete();

        return redirect()->back()->with('toast', '汇总数据已删除');
    }
}