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
        return view('admin.pages.data.create', compact('changeTypes', 'user'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'data' => 'required|numeric|min:0.01',
        ]);

        $data = $request->only("user_id", "type_id", "data");
        $action = ChangeAction::find($data['type_id']);
        $user = User::find($data['user_id']);

        $user->turnover($data['data'], $action->type->action)->save();

        $data['history'] = $user->balance;

        if (!in_array('description', array_keys($data))) $data['description'] = ' ';

        $turnover = new Turnover($data);
        $turnover->save();

        return redirect()->route('admin.data');

    }

    public function deleteId(Request $request)
    {
        Turnover::where('id', $request->input('id'))->delete();
        return redirect()->route('admin.data');
    }

}