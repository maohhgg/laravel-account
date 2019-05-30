<?php


namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;



class AdminsController extends AdminController
{
    public $module = 'admins';
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
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
     * @param  array  $data
     * @return Admin
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     *  delete a Adminstrator
     *
     * @param int $id
     * @return int
     */
    protected function delete($id)
    {
        return Admin::destroy($id);
    }

    public function index()
    {

        $admins = Admin::paginate(10);
        return view('admin.pages.admins.index', compact('admins'));
    }

    public function showCreateForm()
    {
        return view('admin.pages.admins.create');
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