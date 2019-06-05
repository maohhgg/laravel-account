<?php


use Illuminate\Database\Seeder;

class AdminConfigsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('admin_configs')->insert([
            ['key' => 'APPID', 'value' => '00000003'],
            ['key' => 'CUSID', 'value' => '990440148166000'],
            ['key' => 'APPKEY', 'value' => 'a0ea3fa20dbd7bb4d5abf1d59d63bae8'],
            ['key' => 'CHARSET', 'value' => 'UTF-8'],
            ['key' => 'SERVERNAME', 'value' => 'UnionPay international'],
            ['key' => 'RECHARGE', 'value' => 0],
        ]);
    }
}
