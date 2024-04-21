<?php


namespace App\Http\Controllers\Admin;


use App\Models\Action;
use App\Models\Turnover;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class DataController extends Controller
{
    public string $module = 'data';

    /**
     * display all turnover data
     *
     * @param int ...$id user_id
     * @return View
     */
    public function display(int...$id): View
    {
        $items = [
            'id' => '#ID',
            'avatar' => '用户',
            'type' => '行为',
            'data' => '金额',
            'created_at' => '时间',
            'action' => '操作'
        ];

        $cache = $id == null ? new Turnover() : Turnover::where('user_id', $id);
        $results = $cache->orderBy('id', 'desc')->Paginate(10);

        return view('admin.pages.data.index', compact('items', 'results'));
    }

    /**
     * create view
     *
     * @param int ...$id user_id
     * @return View
     */
    public function createForm(int...$id): View
    {
        $results = [];
        $types = Type::getTypeArray();
        $user = empty($id) ? null: User::select('id', 'name')->find($id);

        return view('admin.pages.data.edit', compact('types', 'user', 'results'));
    }

    /**
     * update turnover view
     *
     * @param int ...$id turnover_id
     * @return View|RedirectResponse
     */
    public function updateForm(int...$id): View|RedirectResponse
    {
        $results = Turnover::find($id);

        if ($results){
            $types = Type::getTypeArray();
            $user = User::select('id', 'name')->find($results->user_id);

            return view('admin.pages.data.edit', compact('types', 'user', 'results'));
        }

        return redirect()->route('admin.data');
    }


    /**
     * create a turnover
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request): RedirectResponse
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
    public function update(Request $request): RedirectResponse
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
            ->update(
                $this->saveToUser(
                    $request->only('user_id', 'type_id', 'data', 'description')
                )
            );

        return redirect($request->input('url'))->with('toast', '记录更新完成');
    }

    /**
     * delete a turnover
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function deleteId(Request $request): RedirectResponse
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
    protected function saveToUser(array $data): array
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
     * Turnover id is greater than $id
     * @param int $id
     */
    protected function recoveryUser(int $id): void
    {
        $turnover = Turnover::find($id);
        $a = Action::where('id', $turnover->type_id)->first();
        $user = User::find($turnover->user_id);

        $user->balance = Type::turnover($user->balance, $turnover->data, Type::reverse($a->type->action));

        if ($a->type->action == Type::INCOME) {
            $user->total = Type::expenditure($user->total, $turnover->data);
            Turnover::where([['id', '>', $id], ['user_id', $turnover->user_id]])
                ->decrement('history', $turnover->data);
        } else {
            Turnover::where([['id', '>', $id], ['user_id', $turnover->user_id]])
                ->increment('history', $turnover->data);
        }
        $user->save();
    }

}
