<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Navigation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
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
        $this->middleware('auth.admin:admin');
        View::share('active', str_replace('admin.','', Route::currentRouteName()));
        $nav = Navigation::where(['parent_nav' => 0,'is_admin' => 1])
            ->orderBy('sequence')
            ->with('children')
            ->select('id','action','icon','name','url')
            ->get();
        View::share('menus', $nav);
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
