<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected string $redirectTo = '/admin/login';
    protected string $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }


    /**
     * 自定义认证驱动
     * @return Guard
     */
    protected function guard(): Guard
    {
        return auth()->guard('admin');
    }

    /**
     *   method post delete a Admin
     *
     * @param Request $request
     * @return View
     * @throws ValidationException
     */
    public function showResetForm(Request $request, $token = null): View
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        ]);

        return view('admin.pages.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
