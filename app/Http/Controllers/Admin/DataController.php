<?php


namespace App\Http\Controllers\Admin;


use App\Action;
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
            'avatar' => '用户',
            'type' => '行为',
            'data' => '金额',
            'created_at' => '时间',
            'action' => '操作'];
        $t = $id == null ? new Turnover(): Turnover::where('user_id', $id);
        $results = $t->orderBy('id', 'desc')->Paginate(10);
        return view('admin.pages.data.index', compact('items', 'results'));
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
            'data' => 'required|numeric|min:0.01',
            'description' => 'nullable'
        ]);

        Turnover::create($this->saveToUser($request->only('user_id', 'type_id', 'data', 'description')));

        if($request->input('method')){
            return redirect()->back()->with('toast','创建完成');
        }
        return redirect($request->input('url'))->with('toast','创建完成');
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
            'user_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.01',
            'description' => 'nullable'
        ]);

        $this->recoveryUser($request->input('id'));
        Turnover::find($request->input('id'))
            ->update($this->saveToUser($request->only('user_id', 'type_id', 'data', 'description')));

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

        $this->recoveryUser($request->input('id'));
        Turnover::find($request->input('id'))->delete();
        return redirect()->back()->with('toast', '记录已经删除');
    }


    /**
     * according to turnover data change user balance and total
     *
     * @param array $data
     * @return array mixed
     */
    protected function saveToUser($data)
    {
        $action = Action::find($data['type_id']);
        $user = User::find($data['user_id']);

        $user->balance = Type::turnover($user->balance, $data['data'], $action->type->action);
        $user->total = $action->type->action == Type::INCOME ? Type::income($user->total, $data['data']) : $user->total;
        $user->save();

        $data['history'] = $user->balance;

        return $data;
    }


    /**
     * recovery user balance and total
     *
     * @param number $turnoverId
     */
    protected function recoveryUser($turnoverId)
    {
        $t = Turnover::find($turnoverId);
        $a = Action::where('id', $t->type_id)->first();
        $user = User::find($t->user_id);

        $user->balance = Type::turnover($user->balance, $t->data, Type::reverse($a->type->action));

        if ($a->type->action == Type::INCOME) {
            $user->total = Type::expenditure($user->total, $t->data);
            Turnover::where([['id', '>', $turnoverId], ['user_id', $t->user_id]])->decrement('history', $t->data);
        } else {
            Turnover::where([['id', '>', $turnoverId], ['user_id', $t->user_id]])->increment('history', $t->data);
        }
        $user->save();
    }

}