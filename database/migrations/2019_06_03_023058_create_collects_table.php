<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('total',14,2);
            $table->string('order');
            $table->boolean('is_online');
            $table->integer('user_id');
            $table->integer('turn_id')->default(0);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collects');
    }
}
