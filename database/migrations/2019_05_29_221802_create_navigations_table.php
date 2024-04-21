<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up():void
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action',64);
            $table->string('icon',64);
            $table->string('name',64);
            $table->string('url',64);
            $table->integer('parent_id');
            $table->boolean('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down():void
    {
        Schema::dropIfExists('navigations');
    }
}
