<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key',255);
            $table->string('value',255);
            $table->string('label',128);
        });
    }
    //`label` varchar(150) DEFAULT NULL,
    //`key` varchar(255) DEFAULT NULL,
    //`value` varchar(2555) DEFAULT NULL,
    //`description` varchar(255) DEFAULT NULL,
    //`created_at` datetime DEFAULT NULL,
    //`updated_at` datetime DEFAULT NULL,

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_configs');
    }
}
