<?php

namespace App\Http\Controllers\Admin;

use App\Models\Action;
use App\Models\TradeType;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TypeController extends Controller
{
    public string $module = 'change';


    /**
     * view for display all change_actions
     *
     * @return View
     */
    public function index(): View
    {
        $types = TradeType::getTypes();
        return view('admin.pages.change.index', compact('types'));
    }

    /**
     * create a change_action
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|unique:trade_types,name',
            'is_increase' => 'required|numeric',
        ]);
        TradeType::create($request->only('name', 'is_increase'));
        return redirect()->back()->with('toast','新的方式已经保存!');
    }

    /**
     * update change_action name
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function updateAction(Request $request): void
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|string|max:64|max:1'
        ]);
        TradeType::find($request->input('id'))->update($request->only('name'));
    }

    /**
     *  delete a change_action
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function deleteId(Request $request): void
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        TradeType::find($request->input('id'))->delete();
    }

}
