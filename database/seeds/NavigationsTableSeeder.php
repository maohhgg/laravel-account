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
        $navigations = array(
            array('id' => '1','action' => 'home','icon' => 'home','name' => '首页','url' => 'admin','parent_id' => '0','is_admin' => '1'),
            array('id' => '2','action' => 'menu','icon' => 'users','name' => '用户','url' => '','parent_id' => '0','is_admin' => '1'),
            array('id' => '3','action' => 'data','icon' => 'bar-chart-2','name' => '数据','url' => 'admin.data','parent_id' => '0','is_admin' => '1'),
            array('id' => '4','action' => 'change','icon' => 'trending-up','name' => '收入支出类型','url' => 'admin.change','parent_id' => '0','is_admin' => '1'),
            array('id' => '5','action' => 'users','icon' => 'user','name' => '会员','url' => 'admin.users','parent_id' => '2','is_admin' => '1'),
            array('id' => '6','action' => 'admins','icon' => 'lock','name' => '管理员','url' => 'admin.admins','parent_id' => '2','is_admin' => '1'),
            array('id' => '7','action' => 'home','icon' => 'home','name' => '首页','url' => 'home','parent_id' => '0','is_admin' => '0'),
            array('id' => '8','action' => 'data','icon' => 'package','name' => '数据','url' => '','parent_id' => '0','is_admin' => '0'),
            array('id' => '9','action' => 'history','icon' => 'pie-chart','name' => '历史记录','url' => 'data.history','parent_id' => '8','is_admin' => '0')
        );
        DB::table('navigations')->insert($navigations);
    }
}
