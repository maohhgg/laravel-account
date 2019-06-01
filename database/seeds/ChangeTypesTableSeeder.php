<?php

use Illuminate\Database\Seeder;

class ChangeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('change_types')->insert([
            ['name' => '收入方式', 'action' => 'income', 'icon' => 'trending-up'],
            ['name' => '支出方式', 'action' => 'expenditure', 'icon' => 'trending-down'],
        ]);
    }
}
