<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\Collect;
use App\Turnover;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function PHPSTORM_META\type;

class CollectController extends Controller
{
    public $types = ['0' => '线下交易汇总', '1' => '二维码交易汇总'];
    public $interest = ['0' => 0.0047, '1' => 0.0042];

    public function display($id = null)
    {
        $items = [
            'id' => '#ID',
            'name' => '用户',
            'is_online' => '类型',
            'data' => '总额',
            'created_at' => '日期',
            'action' => '操作'];
        // 判断用户是否存在
        if ($id) {
            if (is_null(User::where('id', $id)->first())) return redirect()->route('admin');
            $c = Collect::where('user_id', $id);
        } else {
            $c = new Collect();
        }
        $results = $c->orderBy('id', 'desc')->Paginate(10);
        $types = $this->types;
        return view('admin.pages.collect.index', compact('items', 'results', 'types'));
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
            if (is_null(User::where('id', $id)->first())) return redirect()->route('admin');
            $user = User::find($id);
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
        $types = $this->types;
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $results = Collect::find($id);
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

        $data = $request->only('user_id', 'is_online', 'data', 'created_at');

        $action = Action::find($data['is_online'] + 1);
        $d = [
            'data' => $data['data'] * $this->interest[$data['is_online']],
            'user_id' => $data['user_id'],
            'type_id' => $action->id,
            'created_at' => Carbon::parse($data['created_at'])->subday(-1)->toDateTimeString(),
        ];

        User::saveToUser($data['user_id'], $d['data'], $action->type->action);


        $data['turn_id'] = Turnover::create($d)->id;
        Collect::create($data);

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

        $data = $request->only('is_online', 'data', 'created_at');

        $new = Action::find($data['is_online'] + 1);
        $d = [
            'data' => $data['data'] * $this->interest[$data['is_online']],
            'type_id' => $new->id,
            'created_at' => Carbon::parse($data['created_at'])->yesterday()->toDateTimeString(),
        ];

        $c = Collect::find($request->input('id'));
        $t = Turnover::find($c->turn_id);

        $old = Action::find($t->type_id)->type->action;

        User::recoveryUser($t, $old);
        User::saveToUser($t->user_id, $d['data'], $new);

        $t->update($d);
        $c->update($data);

        Collect::find($request->input('id'))->update($request->only('is_online', 'data', 'created_at'));
        return redirect($request->input('url'))->with('toast', '汇总数据完成更新');
    }

    /**
     *  method post delete a Collect
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $c = Collect::find($request->input('id'));
        $t = Turnover::find($c->turn_id);
        User::recoveryUser($t, Action::find($t->type_id));
        $t->delete();
        $c->delete();

        return redirect()->back()->with('toast', '汇总数据已删除');
    }
}