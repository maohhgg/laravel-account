<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_configs', function (Blueprint $table) {
            $table->string('key');
            $table->string('value');
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
        Schema::dropIfExists('admin_configs');
    }
}
