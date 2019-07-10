<?php


namespace App\Http\Controllers\Admin;


use App\Action;
use App\Collect;
use App\RechargeOrder;
use App\Type;
use App\Turnover;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class UsersController extends Controller
{

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
     * @return Model
     */
    protected function create(array $data)
    {
        return User::query()->create([
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

        $results = User::query()->Paginate($this->paginate);
        $actionTypes = Type::getTypeArray();
        $collectTypes = Action::getCollect();

        return view('admin.pages.users.index', compact('items', 'results', 'actionTypes', 'collectTypes'));
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
        $user = User::query()->find($id);
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
        $data = User::query()->select('id', 'name as text')
            ->where("name", "LIKE", "%{$request->input('query')}%")
            ->limit($this->paginate)
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

        User::query()->create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect($request->input('url'))->with('toast', '用户创建完成');
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
            'email' => 'nullable:email|max:255',
            'phone' => ['nullable', 'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/'],
            'password' => 'nullable:min:8'
        ]);

        $data = [];
        foreach (['name', 'email', 'phone', 'password'] as $item) {
            $value = $request->input($item);
            if ($value) $data[$item] = $value;
        }
        if (in_array('password', array_keys($data))) $data['password'] = Hash::make($data['password']);

        $user = User::query()->find($request->input('id'));
        $user->timestamps = false;
        $user->update($data);
        return redirect($request->input('url'))->with('toast', '用户数据完成更新');
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
        $user = User::query()->where('id', auth()->user()->id);
        $user->timestamps = false;
        $user->update(['password' => Hash::make($request->input('password'))]);
        return redirect($request->input('url'))->with('toast', '密码已经更新!');
    }

    /**
     *  method post delete a User
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     * @throws \Exception
     */
    public function deleteId(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $id = $request->input('id');
        Turnover::query()->where('user_id', $id)->delete();
        RechargeOrder::query()->where('user_id', $id)->delete();
        Collect::query()->where('user_id', $id)->delete();
        User::query()->find($id)->delete();
        return redirect()->back()->with('toast', '用户已删除');
    }
}
