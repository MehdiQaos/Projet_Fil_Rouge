<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gametypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('length');
            $table->string('move_addtime_type'); // increment, delay, none
            $table->integer('move_addtime'); // seconds
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
        Schema::dropIfExists('gametypes');
    }
};
