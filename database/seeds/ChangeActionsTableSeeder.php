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
            ['name' => '线下交易汇总', 'change_type_id' => 2, 'can_delete' => 0],
            ['name' => '二维码交易汇总', 'change_type_id' => 2, 'can_delete' => 0],
        ]);
    }
}
