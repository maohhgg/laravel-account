<?php


use Illuminate\Database\Seeder;

class ServerConfigsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('server_configs')->insert([
            ['key' => 'APP_ID', 'value' => '00000003', 'label' => 'APP ID'],
            ['key' => 'CUS_ID', 'value' => '990440148166000', 'label' => '商户号'],
            ['key' => 'APP_KEY', 'value' => 'a0ea3fa20dbd7bb4d5abf1d59d63bae8', 'label' => ' APP_KEY 的md5值'],

            ['key' => 'SERVER_NAME', 'value' => 'UnionPay international', 'label' => '网站名称'],
            ['key' => 'RECHARGE_STAT', 'value' => 0, 'label' => '是否启用在线充值'],
            ['key' => 'PAGINATE', 'value' => 15, 'label' => '表格显示多少项'],

            ['key' => 'RECORD_ICP', 'value' => '', 'label' => 'ICP备案信息'],
        ]);
    }
}


