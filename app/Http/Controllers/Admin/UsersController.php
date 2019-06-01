<?php


namespace App\Http\Controllers\Admin;


use App\ChangeType;
use App\Turnover;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{

    public $module = 'users';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function index()
    {
        $items = [
            'id' => '#ID',
            'name' => '名称',
//            'avatar' => '头像',
            'phone' => '电话号码',
            'balance' => '余额',
            'total' => '消费总计',
            'email' => '邮箱',
            'created_at' => '创建时间',
            'updated_at' => '上次登录时间',
            'action' => '操作'];

        $results = User::Paginate(10);
        $changeTypes = ChangeType::where('id', '>', '0')->with('actions')->get();
        return view('admin.pages.users.index', compact('items', 'results', 'changeTypes'));
    }

    public function showCreateForm()
    {
        return view('admin.pages.users.create');
    }

    public function updateForm($id = null)
    {
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $user = User::find($id);
        return view('admin.pages.users.update', compact('user'));
    }


    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $data = User::select('id', 'name as text')
            ->where("name", "LIKE", "%{$request->input('query')}%")
            ->limit(5)
            ->get();
        return response()->json($data);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users,name',
            'password' => 'required|string|min:8',
        ]);
        $data = $request->input();
        $data['password'] = Hash::make($data['password']);
        $user = new User($data);
        $user->save();
        return redirect()->route('admin.users');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'string',
            'email' => 'string|email|max:255',
            'phone' => ['required', 'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/']
        ]);

        $data = $request->input();

        unset($data['id']);
        $user = User::find($request->input('id'));
        $user->update($data);
        return redirect()->route('admin.users');
    }

    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $id = $request->input('id');
        Turnover::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        return redirect()->route('admin.users');
    }
}