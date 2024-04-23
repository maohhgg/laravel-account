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
    public function up():void
    {
        Schema::create('trade_types', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name',64);
            $table->boolean('is_increase')->nullable();
            $table->boolean('is_trade')->default(false);
            $table->boolean('visible')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down():void
    {
        Schema::dropIfExists('change_types');
    }
};
