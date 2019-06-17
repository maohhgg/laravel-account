<?php


namespace App\Http\Controllers\Admin;


use App\Config;
use App\Navigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public $settings;

    public function __construct()
    {
        parent::__construct();
        $this->settings = [
            Config::SERVER_NAME,
            Config::PAGINATE,

            Config::APP_ID,
            Config::CUS_ID,
            Config::APP_KEY,

            Config::RECORD_ICP,

            Config::RECHARGE_STAT,
        ];
    }

    public function index()
    {
        return view('admin.pages.home');
    }

    public function settingForm()
    {
        $diff = Config::RECHARGE_STAT;
        $results = [];
        foreach ($this->settings as $item) {
            $results[] = Config::get($item, true);
        }
        return view('admin.pages.setting', compact('results', 'diff'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function configSave(Request $request)
    {
        $this->validate($request, array_combine($this->settings, array_map(function () {
            return 'required';
        }, $this->settings)));

        $data = [];
        foreach ($this->settings as $item) {
            $value = $request->input($item);
            if (!is_null($value)) $data[$item] = $value;
        }

        $toast = [];
        foreach ($data as $key => $item) {
            if (Config::set($key, $item) != false) {
                $toast[] = Config::get($key, false,'name');
            }
        }
        $toast = count($toast) > 0 ? implode( '，', $toast) . '已经更新' : '配置没发生变化';

        $is_show = Config::get(Config::RECHARGE_STAT);
        Navigation::query()->whereIn('url', ['recharge', 'rechargeOrder'])->update(['is_show' => $is_show]);

        return redirect()->back()->with('toast', $toast);
    }
}