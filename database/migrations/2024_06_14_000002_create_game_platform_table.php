<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_platform', function (Blueprint $table) {
            $table->unsignedBigInteger('id_game');
            $table->unsignedBigInteger('id_platform');
            $table->primary(['id_game', 'id_platform']);
            $table->foreign('id_game')->references('id_game')->on('games')->onDelete('cascade');
            $table->foreign('id_platform')->references('id_platform')->on('platforms')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_platform');
    }
};
