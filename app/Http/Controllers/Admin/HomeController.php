<?php


namespace App\Http\Controllers\Admin;


use App\Config;
use App\Page;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public $module = 'home';

    public function index()
    {
        return view('admin.pages.home');
    }

    public function settingForm()
    {
        $settings = ['server_name', 'QRCode'];
        $results = [];
        foreach ($settings as $item){
            $results[$item] = Config::get($item);
        }
        return view('admin.pages.setting',compact('results'));
    }
}