<?php

use Illuminate\Database\Seeder;

class NavigationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $key = [
            array('home', 'home', '首页', 'admin.home', 1, 0, 1, 1),
            array('data', 'bar-chart-2', '数据', 'admin.data', 2, 0, 1, 1),
            array('collect', 'sidebar', '交易汇总数据', 'admin.collect', 3, 0, 1, 1),
            array('users', 'user', '会员', 'admin.users', 4, 0, 1, 1),
            array('admins', 'lock', '管理员', 'admin.admins', 5, 0, 1, 1),
            array('change', 'trending-up', '收入支出类型', 'admin.change', 6, 0, 1, 1),
            array('settings', 'sliders', '设置', 'admin.settings', 7, 0, 1, 1),
            array('home', 'home', '首页', 'home', 1, 0, 0, 1),
            array('history', 'pie-chart', '历史记录', 'history', 2, 0, 0, 1),
            array('collect', 'sidebar', '每日交易汇总', 'collect', 3, 0, 0, 1),
            array('recharge', 'credit-card', '在线充值', 'recharge', 4, 0, 0, 1),


            array('data', 'clipboard', '全部数据', 'admin.data', 0, 2, 1, 1),
            array('data.create', 'file-plus', '创建数据', 'admin.data.create', 0, 2, 1, 1),
            array('data.update', 'file-plus', '编辑数据', 'admin.data.update', 0, 2, 1, 0),


            array('collect', 'clipboard', '交易汇总数据', 'admin.collect', 0, 3, 1, 1),
            array('collect.create', 'file-plus', '创建汇总数据', 'admin.collect.create', 0, 3, 1, 1),
            array('collect.update', 'file-plus', '编辑汇总数据', 'admin.collect.update', 0, 3, 1, 0),


            array('users', 'clipboard', '所有会员', 'admin.users', 0, 4, 1, 1),
            array('users.create', 'file-plus', '创建会员', 'admin.users.create', 0, 4, 1, 1),
            array('users.update', 'file-plus', '编辑会员', 'admin.users.update', 0, 4, 1, 0),


            array('admins', 'clipboard', '所有管理员', 'admin.admins', 0, 5, 1, 1),
            array('admins.create', 'file-plus', '创建管理员', 'admin.admins.create', 0, 5, 1, 1),
            array('admins.create', 'file-plus', '编辑管理员', 'admin.admins.update', 0, 5, 1, 0),


        ];
        $navigations = array_map(function ($v) {
            return [
                'action' => $v[0],
                'icon' => $v[1],
                'name' => $v[2],
                'url' => $v[3],
                'sequence' => $v[4],
                'parent_nav' => $v[5],
                'is_admin' => $v[6],
                'is_nav' => $v[7]];
        }, $key);

        DB::table('navigations')->insert($navigations);
    }
}
