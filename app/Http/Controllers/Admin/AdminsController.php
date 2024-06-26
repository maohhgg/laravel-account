<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class AdminsController extends Controller
{
    public string $module = 'admins';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Admin
     */
    protected function create(array $data): Admin
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     *  delete a Admin
     *
     * @param int $id
     * @return int
     */
    protected function delete($id): int
    {
        return Admin::destroy($id);
    }

    /**
     *   method post delete a Admin
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function deleteId(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $id = $request->input('id');
        if(auth()->user()->id == $id){
            return redirect()->back()->with('toast', '不能删除自己!');
        }
        Admin::find($request->input('id'))->delete();
        return redirect()->back()->with('toast', '管理员已经创建!');
    }


    /**
     *  display home page
     *
     * @return View
     */
    public function index(): View
    {
        $items = [
            'id' => '#ID',
            'name' => '名称',
//            'avatar' => '头像',
            'email' => '邮箱',
            'created_at' => '创建时间',
            'updated_at' => '上次登录时间',
            'action' => '操作'
        ];

        $results = Admin::paginate(10);
        return view('admin.pages.admins.index', compact('items', 'results'));
    }

    /**
     *  display home page
     *
     * @return Factory|View
     */
    public function createForm(): View
    {
        return view('admin.pages.admins.create');
    }

    public function updateForm($id = null): View|RedirectResponse
    {
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $admin = Admin::find($id);
        return view('admin.pages.admins.update', compact('admin'));
    }

    public function passwordForm($id = null): View
    {
        return view('admin.pages.admins.password');
    }

    public function settingForm(): View
    {
        $admin = Admin::find(auth()->user()->id);
        return view('admin.pages.admins.setting', compact('admin'));
    }

    /**
     * update Admin name email
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateAdmin(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'string',
            'email' => 'string|email|max:255',
            'phone' => 'numeric',
            'icon' => 'numeric',
        ]);

        Admin::find($request->input('id'))->update($request->only('name', 'email', 'icon'));
        return redirect($request->input('url'))->with('toast', '管理员数据已更新!');
    }

    /**
     * change Admin password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'current_password' => ['required', 'string', 'min:8', function ($attribute, $value, $fail) {
                return Hash::check($value, auth()->user()->password) ? true : $fail('当前密码 不匹配');
            }],
            'password' => 'required|string|min:8|confirmed',
        ]);
        Admin::where('id', auth()->user()->id)->update(['password' => Hash::make($request->input('password'))]);
        return redirect($request->input('url'))->with('toast', '密码已经更新!');
    }


    /**
     * create Admin with name and password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function createWithNamePassword(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users,name',
            'password' => 'required|string|min:8',
        ]);

        Admin::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect($request->input('url'))->with('toast', '管理员已经创建!');
    }

    /**
     * 自定义认证驱动
     * @return Guard
     */
    protected function guard(): Guard
    {
        return auth()->guard('admin');
    }
}
