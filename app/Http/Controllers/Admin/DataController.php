<?php


namespace App\Http\Controllers\Admin;


use App\Models\TradeType;
use App\Models\Turnover;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


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
            'data' => '交易金额(元)',
            'other' => '费用类型',
            'third_tax' => '第三方手续费(元)',
            'tax_rate' => '费率',
            'extend_data' => '手续费总计(元)',
            'true_data' => '余额(元)',
            'created_at' => '时间',
            'action' => '操作'
        ];


        $cache = $id ? Turnover::where('user_id', $id) : new Turnover();

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
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.001',
            'third_tax' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0.001',
            'created_at' => 'required|string',
        ]);

        $type = (int)$request->input('type_id'); // 交易类型
        $created_at = Carbon::createFromFormat('Y-m-d',  $request->input('created_at')); // 创建时间

        //储蓄卡交易 封顶20
        /*
        if ($type == TradeType::CREDIT_CARD && $tax < -20){
            $tax = -20;
        }
        */

        DB::beginTransaction();
        try {
            if ($type == TradeType::ADD_CREDIT) {
                $data = [
                    ...$request->only('user_id', 'type_id', 'data'),
                    'created_at' => $created_at
                ];
            } else {
                $data = [
                    ...$request->only('user_id', 'type_id', 'data', 'third_tax', 'tax', 'tax_rate'),
                    'tax_id' => TradeType::CHARGES,
                    'created_at' => $created_at
                ];
            }

            Turnover::create($this->saveToUser($data));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast',"创建失败");
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
            'data' => 'required|numeric|min:0.001',
            'third_tax' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0.001',
            'created_at' => 'required|string',
        ]);


        $type = (int)$request->input('type_id'); //交易类型
        $created_at = Carbon::createFromFormat('Y-m-d',  $request->input('created_at')); // 更新时间
        $cache = Turnover::find($request->input('id'));

        //储蓄卡交易 封顶20
        /*
        if ($type == TradeType::CREDIT_CARD && $tax < -20){
            $tax = -20;
        }
        */

        if (!$cache->id){
            return redirect()->back()->with('toast','完成');
        }

        DB::beginTransaction();
        try {
            $this->recoveryUser($cache->id);

            if ($type == TradeType::ADD_CREDIT) {
                $data = [...$request->only('user_id', 'type_id', 'data'), 'created_at' => $created_at];
            } else {
                $data = [...$request->only('user_id', 'type_id', 'data', 'tax_rate', 'third_tax', 'tax'),
                    'tax_id' => TradeType::CHARGES,
                    'created_at' => $created_at
                ];
            }

            $cache->update($this->saveToUser($data));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast','更新失败');
        }


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
        if (!$cache->id){
            return redirect()->back()->with('toast','完成');
        }

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

        if ((int)$data['type_id'] == TradeType::ADD_CREDIT){
            $user->balance += $data['data'];
            $user->total += $data['data'];
        } else {
            $user->balance += $data['tax'];
        }

        $data['history'] = $user->balance;
        $user->save();

        return $data;
    }


    /**
     * recovery user balance and total
     * Turnover id is greater than $id
     * @param int $id
     */
    protected function recoveryUser(int $id): void
    {
        $cache = Turnover::find($id);
         if ($cache->type->id == TradeType::ADD_CREDIT){
             $cache->user->balance -= $cache->data;
         } else {
             $cache->user->balance -= $cache->tax;
         }
        $cache->user->save();
    }

}
