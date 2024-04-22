<?php


namespace App\Http\Controllers\Admin;


use App\Models\TradeType;
use App\Models\Turnover;
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
            'description' => '交易类型',
            'data' => '交易金额',
            'other' => '其他费用',
            'extend_data' => '其他费用金额',
            'true_data' => '到账金额',
            'created_at' => '时间',
            'action' => '操作'
        ];

        if ($id == null) {
            $cache = Turnover::where('parent_id', '=', null);
        } else {
            $cache = Turnover::where([['user_id', $id], ['parent_id', '=', null]]);
        }

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
        $results = null;
        $types = TradeType::getTypes();
        $user = empty($id) ? null: User::select('id', 'name')->find($id);

        return view('admin.pages.data.edit', compact('types', 'user', 'results'));
    }

    /**
     * update turnover view
     *
     * @param int $id turnover_id
     * @return View|RedirectResponse
     */
    public function updateForm(int $id)
    {
        $results = Turnover::find($id);

        if ($results){
            $types = TradeType::getTypes();
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

        $id = Turnover::create(
            $this->saveToUser(
                $request->only('user_id', 'type_id', 'data', 'description')
            )
        )->id;

        if ($request->input('exist_extend') != 0){
            Turnover::create(
                $this->saveToUser([
                    ...$request->only('user_id'),
                    'parent_id' => $id,
                    'description' => '系统自动完成',
                    'type_id'=>$request->input('extend_type_id'),
                    'data' => $request->input('extend_data'),
                ])
            );
        }



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
            'exist_extend' => 'numeric|required',
            'description' => 'nullable'
        ]);

        $cache = Turnover::find($request->input('id'));
        $this->recoveryUser($cache->id);

        if ($request->input('exist_extend') != 0){
            if ($cache->children){
                $this->recoveryUser($cache->children->id);
                $cache->children->update(
                    $this->saveToUser([
                        ...$request->only('user_id'),
                        'type_id'=>$request->input('extend_type_id'),
                        'data' => $request->input('extend_data'),
                    ])
                );
            }
            Turnover::create(
                $this->saveToUser([
                    ...$request->only('user_id'),
                    'parent_id' => $cache->id,
                    'description' => '系统自动完成',
                    'type_id'=>$request->input('extend_type_id'),
                    'data' => $request->input('extend_data'),
                ])
            );


        } elseif ($cache->children) {
            $this->recoveryUser($cache->children->id);
            Turnover::find($cache->children->id)->delete();
        }

        $cache->update($this->saveToUser(
            $request->only('user_id', 'type_id', 'data', 'description')
        ));

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

        $cache = Turnover::find($request->input('id'));

        $this->recoveryUser($cache->id);

        if ($cache->children) {
            $this->recoveryUser($cache->children->id);
            $cache->children->delete();
        }
        $cache->delete();

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
        $user = User::find($data['user_id']);
        $type= TradeType::find($data['type_id']);

        if ($type->is_increase){
            $user->total += $data['data'];
        }else{
            $data['data'] = -$data['data'];
        }

        $user->balance += $data['data'];

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
        $type= TradeType::find($turnover->type_id);
        $user = User::find($turnover->user_id);

        $user->balance -= $turnover->data;;

        if ($type->is_increase) $user->total -= $turnover->data;

        $user->save();
    }

}
