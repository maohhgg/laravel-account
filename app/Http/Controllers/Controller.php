<?php

namespace App\Http\Controllers;

use App\Navigation;
use App\Page;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $breadcrumbs;

    /**
     * iZgeidm3894rguZ
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        View::share('active', Route::currentRouteName());
        View::share('menus', Navigation::where([['parent_nav', 0], ['is_admin', 0], ['is_nav', 1]])->with('children')->orderBy('sequence')->get());

        $page = Navigation::where('url', Route::currentRouteName())->with('parent')->first();
        if ($page) {
            $this->breadcrumbs = [];
            while ($page->parent) {
                $b = $page;
                unset($b->parent);
                array_unshift($this->breadcrumbs, $b);
                $page = $page->parent;
            }

        }
        View::share('breadcrumbs', $this->breadcrumbs);
        if($page){
            View::share('title', $page->name.' ---- UnionPay international');
        }
    }
}
