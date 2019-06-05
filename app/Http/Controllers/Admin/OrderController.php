<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\RechargeOrder;
use App\Turnover;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public $types = ['0' => '线下交易汇总', '1' => '二维码交易汇总'];
    public $interest = ['0' => 0.0047, '1' => 0.0042];
    public $items = [
        'id' => '#ID',
        'order' => '单号',
        'torder' => '数据流水单号',
        'name' => '用户',
        'data' => '金额',
        'created_at' => '日期',
        'is_cancel' => '状态',
        'action' => '操作'];

    public function display($id = null)
    {
        $user = null;
        if ($id) {
            $user = User::where('id', $id)->first();
            if (is_null($user)) return redirect()->route('admin.home');
            $r = RechargeOrder::where('user_id', $id);
        } else {
            $r = new RechargeOrder();
        }

        $results = $r->orderBy('id', 'desc')->Paginate($this->paginate);

        return $this->render($results, $user);
    }

    public function order($order = null)
    {
        if ($order) {
            $results = RechargeOrder::where('order', $order)->Paginate(1);
            return $this->render($results, null, $order);
        }
        return redirect()->route('admin.home');
    }

    protected function render($results, $user = null, $order = null)
    {
        $items = $this->items;
        $types = $this->types;
        return view('admin.pages.order.index', compact('items', 'results', 'types', 'user', 'order'));
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
        $c = RechargeOrder::find($request->input('id'));
        $t = Turnover::find($c->turn_id);
        if (!is_null($t)) {
            User::recoveryUser($t, Action::find($t->type_id));
            $t->delete();
        }

        $c->delete();
        return redirect()->back()->with('toast', '充值订单已删除');
    }
}