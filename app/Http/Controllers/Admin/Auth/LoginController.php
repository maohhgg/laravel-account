<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        }  else {
            $fieldType = 'name';
        }
        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */

    public function username()
    {
        return $this->username;
    }

    /**
     * 重写登录视图页面
     */
    public function showLogin()
    {
        return view('admin.pages.auth.login');
    }

    protected function authenticated(Request $request)
    {
        return redirect($this->redirectTo); //put your redirect url here
    }

    /**
     * 自定义认证驱动
     * @return mixed
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

}
