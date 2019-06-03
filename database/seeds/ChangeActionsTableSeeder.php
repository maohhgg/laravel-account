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
            ['name' => '充值', 'change_type_id' => 1],
            ['name' => '购买', 'change_type_id' => 2],
        ]);
    }
}
