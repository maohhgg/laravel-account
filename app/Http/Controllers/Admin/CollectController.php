<?php


namespace App\Http\Controllers\Admin;


use App\Collect;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CollectController extends Controller
{
    public $module = 'collect';

    public function display($id = null)
    {
        $items = [
            'id' => '#ID',
            'name' => '用户',
            'is_online' => '类型',
            'data' => '总额',
            'created_at' => '日期',
            'action' => '操作'];
        // 判断用户是否存在
        if ($id) {
            if (is_null(User::where('id',$id)->first())) return redirect()->route('admin');
            $c = Collect::where('user_id', $id);
        } else {
            $c = new Collect();
        }
        $results = $c->orderBy('id', 'desc')->Paginate(10);
        return view('admin.pages.collect.index', compact('items', 'results'));
    }

    /**
     * Show the form for creating a new Collect.
     * @param null $id user_id
     * @return Factory|View
     */
    public function createFrom($id = null)
    {
        $types = ['0' => '线下交易汇总', '1' => '在线交易汇总'];
        if ($id) {
            if (is_null(User::where('id',$id)->first())) return redirect()->route('admin');
            $user = User::find($id);
            return view('admin.pages.collect.edit', compact('user', 'types'));
        } else {
            return view('admin.pages.collect.edit', compact('types'));
        }
    }

    /**
     * Show the form for update a Collect.
     *
     * @param null $id collect_id
     * @return Factory|View
     */
    public function updateForm($id = null)
    {
        $types = ['0' => '线下交易汇总', '1' => '在线交易汇总'];
        if (!$id || !is_numeric($id)) return redirect()->route('admin');
        $results = Collect::find($id);
        return view('admin.pages.collect.edit', compact('results', 'types'));
    }

    /**
     * create a Collect
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'is_online' => 'required|numeric',
            'data' => 'required|numeric|min:0.01|max:99999999999',
            'created_at' => 'required|date'
        ]);

        Collect::create($request->only('user_id', 'is_online', 'data', 'created_at'));

        return $request->input('method') ?
            redirect()->back()->with('toast', '创建完成') :
            redirect()->route('admin.collect')->with('toast', '创建完成');
    }


    /**
     *  method post delete a Collect
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateCollect(Request $request)
    {
        $this->validate($request, [
            'is_online' => 'numeric',
            'data' => 'numeric|min:0.01|max:99999999999',
            'created_at' => 'date'
        ]);

        Collect::find($request->input('id'))->update($request->only('is_online', 'data', 'created_at'));
        return redirect($request->input('url'))->with('toast', '汇总数据完成更新');
    }

    /**
     *  method post delete a Collect
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
        Collect::find($request->input('id'))->delete();
        return redirect()->back()->with('toast', '汇总数据已删除');
    }
}