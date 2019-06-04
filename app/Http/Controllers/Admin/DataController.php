<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\Library\Order;
use App\Type;
use App\Turnover;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class DataController extends Controller
{
    public $module = 'data';

    /**
     * display all turnover data
     *
     * @param null|number $id user_id
     * @return Factory|View
     */
    public function display($id = null)
    {
        $items = [
            'id' => '#ID',
            'order' => '单号',
            'avatar' => '用户',
            'type' => '行为',
            'collect' => '所属',
            'data' => '金额',
            'created_at' => '时间',
            'action' => '操作'];
        // 判断用户是否存在
        $user = null;
        if ($id) {
            $user = User::where('id', $id)->first();
            if (is_null($user)) return redirect()->route('admin');
            $t = Turnover::where('user_id', $id);
        } else {
            $t = new Turnover();
        }
//        dd($t->find(1)->hasOrder);

        $results = $t->orderBy('id', 'desc')->Paginate(15);
        return view('admin.pages.data.index', compact('items', 'results', 'user'));
    }

    /**
     * create view
     *
     * @param null $id user_id
     * @return Factory|View
     */
    public function createForm($id = null)
    {
        $results = [];
        $types = Type::getTypeArray();
        $user = !empty($id) ? User::select('id', 'name')->find($id) : null;
        return view('admin.pages.data.edit', compact('types', 'user', 'results'));
    }

    /**
     * update turnover view
     *
     * @param null $id turnover_id
     * @return Factory|RedirectResponse|View
     */
    public function updateForm($id = null)
    {
        $results = Turnover::find($id);
        if (!$results) return redirect()->route('admin.data');

        $types = Type::getTypeArray();
        $user = User::select('id', 'name')->find($results->user_id);
        return view('admin.pages.data.edit', compact('types', 'user', 'results'));
    }


    /**
     * create a turnover
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.01|max:99999999999',
            'description' => 'nullable',
        ]);

        $data = $request->only('user_id', 'type_id', 'data', 'description');
        $action = Action::find($data['type_id'])->type->action;

        User::saveToUser($data['user_id'], $data['data'], $action);
        $data['order'] = Order::order();
        $data['is_recharge'] = 0;
        Turnover::create($data);

        return $request->input('method') ?
            redirect()->back()->with('toast', '创建完成') :
            redirect()->route('admin.data')->with('toast', '创建完成');
    }


    /**
     * turnover update
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.01|max:99999999999',
            'description' => 'nullable',
            'created_at' => 'date'
        ]);
        $data = $request->only('type_id', 'data', 'description', 'created_at');

        $t = Turnover::find($request->input('id'));

        $old = Action::find($t->type_id)->type->action;
        $new = Action::find($request->input('type_id'))->type->action;

        User::recoveryUser($t, $old);
        User::saveToUser($t->user_id, $data['data'], $new);

        $t->update($data);

        return redirect($request->input('url'))->with('toast', '记录更新完成');
    }

    /**
     * delete a turnover
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);

        $t = Turnover::find($request->input('id'));
        User::recoveryUser($t, Action::find($t->type_id));

        $t->delete();
        return redirect()->back()->with('toast', '记录已经删除');
    }



}