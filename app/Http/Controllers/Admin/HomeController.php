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

            Config::COLLECT_OFFLINE,
            Config::COLLECT_ONLINE,

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
        foreach ($this->settings as $item) {
            $results[] = Config::getAll($item);
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
            $data[$item] = $request->input($item);
        }

        foreach ($data as $key => $item) {
            Config::set($key, $item);
        }

        $is_show = Config::get(Config::RECHARGE_STAT);
        Navigation::query()->whereIn('url', ['recharge', 'rechargeOrder'])->update(['is_show' => $is_show]);

        return redirect()->back()->with('toast', '服务器配置已经更新');
    }
}