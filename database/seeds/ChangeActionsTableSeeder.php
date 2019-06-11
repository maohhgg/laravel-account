<?php

use Illuminate\Database\Seeder;

class ChangeActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('change_actions')->insert([
            ['id' => 1, 'name' => '线下交易汇总', 'change_type_id' => 2, 'can_delete' => 0],
            ['id' => 2, 'name' => '二维码交易汇总', 'change_type_id' => 2, 'can_delete' => 0],
            ['id' => 3, 'name' => '充值黄金会员', 'change_type_id' => 1, 'can_delete' => 0],
            ['id' => 4, 'name' => '充值铂金会员', 'change_type_id' => 1, 'can_delete' => 0],
            ['id' => 5, 'name' => '充值砖石会员', 'change_type_id' => 1, 'can_delete' => 0],
            ['id' => 6, 'name' => '充值', 'change_type_id' => 1, 'can_delete' => 0],
        ]);
    }
}
