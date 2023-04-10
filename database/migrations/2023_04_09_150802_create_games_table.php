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
        // chess game
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('white_player_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('black_player_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('gametype_id')->nullable()->constrained()->nullOnDelete();
            $table->string('result'); // 1-0, 0-1, 1/2-1/2
            $table->longText('pgn');
            $table->date('date');
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
        Schema::dropIfExists('games');
    }
};
