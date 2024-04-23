<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
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
            $table->decimal('data',10,4);
            $table->decimal('history',10,4);
            $table->decimal('tax_rate',8,4)->nullable();
            $table->decimal('tax',10,4)->nullable();
            $table->integer('tax_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('type_id');
            $table->integer('user_id')->index();
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
};
