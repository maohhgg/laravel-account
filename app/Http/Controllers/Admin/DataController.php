<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Support\Arr;

class DataController extends AdminController
{
    public $module = 'data';

    public function index()
    {
        $showItem = [
            'id' => '#ID',
            'avatar' => '用户',
            'type' => '行为',
            'data' => '金额',
            'create_at' => '时间',
            'action' => '操作'];
        $data = [];

        return view('admin.pages.data.index', compact('showItem', 'data'));
    }

    public function createForm()
    {
        return view('admin.pages.data.create');
    }
}