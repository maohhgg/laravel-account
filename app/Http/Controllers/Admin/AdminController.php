<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Navigation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{

    public $breadcrumbs;
    public $module;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin:admin');
        View::share('active', $this->module);
        View::share('menus', Navigation::where('parent_id', '0')->with('children')->get());
        $page = Page::where('url', Route::currentRouteName())->with('parent')->first();
        if($page){
            $this->breadcrumbs = [];
            while ($page->parent){
                $b = $page;unset($b->parent);
                array_unshift($this->breadcrumbs, $b);
                $page = $page->parent;
            }
            unset($page);
        }
        View::share('breadcrumbs', $this->breadcrumbs);
    }

}
