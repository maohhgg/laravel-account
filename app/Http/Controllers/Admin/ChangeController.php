<?php


namespace App\Http\Controllers\Admin;


use App\ChangeAction;
use App\ChangeType;

class ChangeController extends AdminController
{
    const INCOME = 'income';
    const EXPENDITURE = 'expenditure';
    public $module = 'change';

    public function index()
    {
        $changeTypes = ChangeType::where('id', '>', '0')->with('actions')->get();
        return view('admin.pages.change.index', compact('changeTypes'));
    }


}