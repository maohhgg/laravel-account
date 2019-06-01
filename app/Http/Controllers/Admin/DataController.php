<?php


namespace App\Http\Controllers\Admin;


use App\ChangeAction;
use App\ChangeType;
use App\Turnover;
use App\User;
use Illuminate\Http\Request;


class DataController extends Controller
{
    public $module = 'data';

    public function index()
    {
        $items = [
            'id' => '#ID',
            'avatar' => '用户',
            'type' => '行为',
            'data' => '金额',
            'created_at' => '时间',
            'action' => '操作'];

        $results = Turnover::orderBy('id', 'desc')->Paginate(10);
        return view('admin.pages.data.index', compact('items', 'results'));
    }

    public function createForm($id = null)
    {
        $changeTypes = ChangeType::where('id', '>', '0')->with('actions')->get();
        $user = !empty($id) ? User::where('id', $id)->select('id', 'name')->first() : null;
        $results = [];
        return view('admin.pages.data.edit', compact('changeTypes', 'user', 'results'));
    }

    public function updateForm($id = null)
    {
        $results = Turnover::find($id);
        if (!$results) {
            return redirect()->route('admin.data');
        }
        $changeTypes = ChangeType::where('id', '>', '0')->with('actions')->get();
        $user = User::where('id', $results->user_id)->select('id', 'name')->first();
//        dd($results);
        return view('admin.pages.data.edit', compact('changeTypes', 'user', 'results'));
    }


    // 保存用户数据
    public function saveToUser($data)
    {
        $action = ChangeAction::find($data['type_id']);
        $user = User::find($data['user_id']);

        // 更改总额
        $user->balance = ChangeType::turnover($user->balance, $data['data'], $action->type->action);
        if ($action->type->action == ChangeType::INCOME) {
            $user->total = ChangeType::income($user->total, $data['data']);
        }
        $user->save();

        $data['history'] = $user->balance;

        return $data;
    }

    // 还原用户数据
    public function recoveryUser($id)
    {
        $d = Turnover::find($id);
        $action = ChangeAction::where('id', $d->type_id)->first();
        $user = User::find($d->user_id);

        $user->balance = ChangeType::turnover($user->balance, $d->data, ChangeType::reverse($action->type->action));

        if ($action->type->action == ChangeType::INCOME) {
            $user->total = ChangeType::expenditure($user->total, $d->data);
            Turnover::where([['id', '>', $id], ['user_id', $d->user_id]])->decrement('history', $d->data);
        } else {
            Turnover::where([['id', '>', $id], ['user_id', $d->user_id]])->increment('history', $d->data);
        }
        $user->save();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.01',
            'description' => 'nullable'
        ]);


        $data = $request->input();

        $data = $this->saveToUser($data);

        $turnover = new Turnover($data);
        $turnover->save();

        return redirect()->route('admin.data');
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.01',
            'description' => 'nullable'
        ]);

        $data = $request->input();
        $this->recoveryUser($data['id']);
        $turnover = Turnover::find($data['id']);

        unset($data['id']);
        $data = $this->saveToUser($data);
        $turnover->update($data);

        return redirect()->route('admin.data');
    }

    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $id = $request->input('id');

        $this->recoveryUser($id);
        // 删除
        Turnover::where('id', $request->input('id', $id))->delete();
        return redirect()->route('admin.data');
    }



}