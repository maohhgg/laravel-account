<?php

namespace App\Http\Controllers\Admin;

use App\Models\Navigation;
use App\Models\Page;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public array $breadcrumbs;
    public string $module;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->breadcrumbs = [];
        $this->middleware('auth.admin:admin');

        View::share('active', $this->module);
        View::share('menus', Navigation::where([['parent_id', '0'], ['is_admin', '1']])->with('children')->get());
        $page = Page::where('url', Route::currentRouteName())->with('parent')->first();
        if ($page) {
            while ($page->parent) {
                $cache = $page;
                unset($cache->parent);
                array_unshift($this->breadcrumbs, $cache);
                $page = $page->parent;
            }
        }
        View::share('breadcrumbs', $this->breadcrumbs);
    }

}
