<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\Type;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ChangeController extends Controller
{
    public $module = 'change';


    /**
     * view for display all change_actions
     *
     * @return Factory|View
     */
    public function display()
    {
        $types = Type::where('id', '>', '0')->with('actions')->get();
        return view('admin.pages.change.index', compact('types'));
    }

    /**
     * create a change_action
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:change_actions,name|max:255|min:1',
            'change_type_id' => 'required|exists:change_types,id',
        ]);
        $data = $request->only('name', 'change_type_id');
        $data['can_delete'] = 1;
        Action::create($data);
        return redirect()->back()->with('toast','新的方式已经保存!');
    }

    /**
     * update change_action name
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function updateAction(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|string|unique:change_actions,name|max:255|min:1'
        ]);
        Action::find($request->input('id'))->update($request->only('name'));
    }

    /**
     *  delete a change_action
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        Action::find($request->input('id'))->delete();
    }

}