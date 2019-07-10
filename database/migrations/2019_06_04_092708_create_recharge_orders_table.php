<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('turn_id')->nullable();
            $table->string('allinpay_id')->nullable();
            $table->string('chnltrx_id')->nullable();
            $table->string('order');
            $table->string('turn_order');
            $table->string('goods');
            $table->string('goods_inf');
            $table->decimal('pay_number',14,2);
            $table->integer('order_status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recharge_orders');
    }
}
