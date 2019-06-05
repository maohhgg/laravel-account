<?php


namespace App\Http\Controllers\Admin;


use App\Config;
use App\Navigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public $module = 'home';
    public $settings = [
        'SERVERNAME' => '网站名称',
        'CUSID' => '商户号',
        'APPID' => 'APPID',
        'APPKEY' => 'MD5KEY',
        'RECHARGE' => 'MD5KEY',
    ];

    public function index()
    {
        return view('admin.pages.home');
    }

    public function settingForm()
    {
        foreach ($this->settings as $key => $item) {
            $results[$key] = ['name' => $item, 'value' => Config::get($key)];
        }
        return view('admin.pages.setting', compact('results'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function configSave(Request $request)
    {
        $results = [];
        $keys = array_keys($this->settings);
        foreach ($keys as $item) {
            $results[$item] = 'required';
        }
        $this->validate($request, $results);

        $data = [];
        foreach ($keys as $item) {
            $data[$item] = $request->input($item);
        }

        foreach ($data as $key => $item) {
            Config::set($key, $item);
        }

        $is_show = Config::get('RECHARGE');
        Navigation::where('url','recharge')->update(['is_show' => $is_show]);
        Navigation::where('url','rechargeOrder')->update(['is_show' => $is_show]);

        return redirect()->back()->with('toast', '服务器配置已经更新');
    }
}