<?php


namespace App\Http\Controllers\Admin;


use App\ChangeAction;
use App\ChangeType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChangeController extends Controller
{
    public $module = 'change';

    public function index()
    {
        $changeTypes = ChangeType::where('id', '>', '0')->with('actions')->get();
        return view('admin.pages.change.index', compact('changeTypes'));
    }

    public function updateData(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'change_type_id' => 'required|numeric'
        ]);

        $data = $request->input();
        if (in_array('id', array_keys($data))) {
            $c = ChangeAction::find($data['id']);
            unset($data['id']);
            unset($data['_token']);
            response()->json($c->update($data));
        }

    }

    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        response()->json( ChangeAction::where('id',$request->input('id'))->delete());
    }

}