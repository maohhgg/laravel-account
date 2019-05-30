<?php


namespace App\Http\Controllers\Admin;


use App\Page;
use Illuminate\Support\Facades\Route;

class HomeController extends AdminController
{
    public $module = 'home';

    public function index()
    {
        $breadcrumbs = Page::where('url',Route::currentRouteName())->get()->toArray();
        return view('admin.pages.home',compact('breadcrumbs'));
    }
}