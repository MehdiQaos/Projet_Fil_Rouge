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
        Schema::create('gamerules', function (Blueprint $table) {
            $table->id();
            $table->integer('length');
            $table->string('move_addtime_type'); // increment, delay, none
            $table->integer('move_addtime'); // seconds
            $table->foreignId('gametype_id')->constrained('gametypes')->onDelete('cascade');
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
        Schema::dropIfExists('gamerules');
    }
};
