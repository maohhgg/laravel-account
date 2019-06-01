<?php


namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;


class AdminsController extends Controller
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
        $items = [
            'id' => '#ID',
            'name' => '名称',
//            'avatar' => '头像',
            'email' => '邮箱',
            'created_at' => '创建时间',
            'updated_at' => '上次登录时间',
            'action' => '操作'];

        $results = Admin::paginate(10);
        return view('admin.pages.admins.index',compact('items','results'));
    }

    public function showCreateForm()
    {
        return view('admin.pages.admins.create');
    }

    public function updateForm($id = null)
    {
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $admin = Admin::find($id);
        return view('admin.pages.admins.update', compact('admin'));
    }

    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        Admin::where('id',$request->input('id'))->delete();
        return redirect()->route('admin.admins');
    }

    public function updateData(Request $request)
    {
        $this->validate($request, [
            'name' => 'string',
            'email' => 'string|email|max:255',
        ]);

        $data = $request->input();

        unset($data['id']);
        $admin = Admin::find($request->input('id'));
        $admin->update($data);
        return redirect()->route('admin.admins');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users,name',
            'password' => 'required|string|min:8',
        ]);

        $data = $request->input();
        $data['password'] = Hash::make($data['password']);
        $admin = new Admin($data);
        $admin->save();
        return redirect()->route('admin.admins');
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