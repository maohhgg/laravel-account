<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = array(
            array('id' => '1','name' => '会员列表','url' => 'admin.users','navigation_id' => '5'),
            array('id' => '2','name' => '建立新会员','url' => 'admin.users.create','navigation_id' => '5'),
            array('id' => '3','name' => '管理员列表','url' => 'admin.admins','navigation_id' => '6'),
            array('id' => '4','name' => '建立新管理员','url' => 'admin.admins.create','navigation_id' => '6'),
            array('id' => '5','name' => '全部数据','url' => 'admin.data','navigation_id' => '3'),
            array('id' => '6','name' => '类型','url' => 'admin.change','navigation_id' => '4'),
            array('id' => '8','name' => '新建数据','url' => 'admin.data.create','navigation_id' => '3'),
            array('id' => '9','name' => '历史记录','url' => 'data.history','navigation_id' => '8')
        );

        DB::table('pages')->insert($pages);
    }
}
