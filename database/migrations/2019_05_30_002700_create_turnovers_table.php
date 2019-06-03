<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnovers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('data',14,2);
            $table->decimal('history',14,2);
            $table->string('description')->nullable();
            $table->integer('type_id');
            $table->integer('user_id')->index();
            $table->integer('pre_id');
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
        Schema::dropIfExists('turnovers');
    }
}
