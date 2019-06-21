<?php


namespace App\Http\Controllers\Admin;


use App\Type;
use App\Turnover;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


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
     * @return User
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
        $types = Type::getTypeArray();
        return view('admin.pages.users.index', compact('items', 'results', 'types'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Factory|View
     */
    public function createForm()
    {
        return view('admin.pages.users.create');
    }

    /**
     * Show the form for update a user.
     *
     * @param null $id
     * @return Factory|View
     */
    public function updateForm($id = null)
    {
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $user = User::find($id);
        return view('admin.pages.users.update', compact('user'));
    }


    /**
     * response username json resource for creating a new turnover.
     *
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


    /**
     * create User with name and password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function createWithNamePassword(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users,name',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect($request->input('url'))->with('toast','用户创建完成');
    }

    /**
     *  method post delete a User
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'string',
            'email' => 'string|email|max:255',
            'phone' => ['required', 'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/']
        ]);

        User::find($request->input('id'))->update($request->only('name', 'email', 'phone'));
        return redirect($request->input('url'))->with('toast','用户数据完成更新');
    }

    /**
     *  method post delete a User
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $id = $request->input('id');
        Turnover::where('user_id', $id)->delete();
        User::find($id)->delete();
        return redirect()->back()->with('toast','用户已删除');
    }
}