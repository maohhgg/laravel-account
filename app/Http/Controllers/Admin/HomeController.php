<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class HomeController extends Controller
{

    public string $module = 'home';

    public function index():View
    {
        $breadcrumbs = Page::where('url',Route::currentRouteName())->get()->toArray();

        return view('admin.pages.home', compact('breadcrumbs'));
    }

}
