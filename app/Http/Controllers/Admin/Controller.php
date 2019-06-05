<?php

namespace App\Http\Controllers\Admin;

use App\Config;
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
    public $paginate;

    /**
     * iZgeidm3894rguZ
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin:admin');

        $serverName = Config::get('SERVERNAME');
        $this->paginate = Config::get('PAGINATE');

        $nav = Navigation::query()->where(['parent_nav' => false,'is_admin' => true])
            ->orderBy('sequence')
            ->with('children')
            ->select('id','action','icon','name','url')
            ->get();
        $page = Navigation::query()->where('url', Route::currentRouteName())->with('parent')->first();


        if ($page) {
            $title = $page->name . ' 后台管理 - ' . $serverName;
            $this->breadcrumbs = [];
            while ($page->parent) {
                $b = $page;
                unset($b->parent);
                array_unshift($this->breadcrumbs, $b);
                $page = $page->parent;
            }
        } else {
            $title = ' 后台管理 - ' . $serverName;
        }

        View::share('menus', $nav);
        View::share('breadcrumbs', $this->breadcrumbs);
        View::share('active', str_replace('admin.','', Route::currentRouteName()));
        View::share('title',  $title);
    }

}
