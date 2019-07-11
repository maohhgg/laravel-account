<?php

namespace App\Http\Controllers;

use App\Config;
use App\Navigation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $paginate;

    /**
     * iZgeidm3894rguZ
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $serverName = Config::get('SERVER_NAME');
        $this->paginate = Config::get('PAGINATE') * 2; // 前台的表格较小
        $nav = Navigation::query()->where([['parent_nav', false], ['is_admin', false], ['is_nav', true], ['is_show', true]])
            ->with('children')
            ->orderBy('sequence')
            ->get();

        $page = Navigation::query()->where('url', Route::currentRouteName())->with('parent')->first();
        if ($page) {
            $title = $page->name . ' - ' . $serverName;
        } else {
            $title = $serverName;
        }

        View::share('active', Route::currentRouteName());
        View::share('menus', $nav);
        View::share('title',  $title);
        View::share('icp',  Config::get('RECORD_ICP'));

    }
}
