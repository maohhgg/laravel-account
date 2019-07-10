<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('order_status')->insert([
            ['sign'=>'SUCCESS', 'label' => '充值完成'],
            ['sign'=>'CANCEL', 'label' => '订单已取消'],
            ['sign'=>'PROCESS', 'label' => '订单处理中'],
            ['sign'=>'FAIL', 'label' => '交易失败'],
        ]);
    }
}
