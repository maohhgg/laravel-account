<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\Collect;
use App\Library\Recharge;
use App\RechargeOrder;
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

    public function display()
    {
        $items = [
            'looper' => '#ID',
            'id' => 'UID',
            'name' => '名称',
            'phone' => '电话号码',
            'balance' => '余额',
            'email' => '邮箱',
            'created_at' => '创建时间',
            'updated_at' => '上次登录时间',
            'action' => '操作'];

        $results = User::Paginate($this->paginate);
        $actionTypes = Type::getTypeArray();
        $collectTypes = Action::getCollect();

        return view('admin.pages.users.index', compact('items', 'results', 'actionTypes','collectTypes'));
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

    public function passwordForm()
    {
        return view('home.pages.password');
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
            'id' => 'required',
            'name' => 'string',
            'email' => 'string|email|max:255',
            'phone' => ['required', 'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/'],
            'password' => 'string:min:8'
        ]);
        $data = $request->only('name', 'email', 'phone', 'password');
        $u = User::find($request->input('id'));
        if ($data['password']!=$u->password){
            $data['password'] = Hash::make($data['password']);
        }

        $u->update($data);
        return redirect($request->input('url'))->with('toast','用户数据完成更新');
    }

    /**
     * change Admin password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', 'string', 'min:8', function ($attribute, $value, $fail) {
                return Hash::check($value, auth()->user()->password) ? true : $fail('当前密码 不匹配');
            }],
            'password' => 'required|string|min:8|confirmed',
        ]);
        User::where('id', auth()->user()->id)->update(['password' => Hash::make($request->input('password'))]);
        return redirect($request->input('url'))->with('toast', '密码已经更新!');
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
        RechargeOrder::where('user_id', $id)->delete();
        Collect::where('user_id', $id)->delete();
        User::find($id)->delete();
        return redirect()->back()->with('toast','用户已删除');
    }
}