<?php


use Illuminate\Database\Seeder;

class AdminConfigsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('admin_configs')->insert([
            ['key' => 'APPID', 'value' => '00000051'],
            ['key' => 'CUSID', 'value' => '990581007426001'],
            ['key' => 'APPKEY', 'value' => 'allinpay888'],
            ['key' => 'CHARSET', 'value' => 'UTF-8'],
            ['key' => 'SERVERNAME', 'value' => 'UnionPay international'],
        ]);
    }
}
