<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_game', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_game');
            $table->enum('status', ['wishlist', 'owned', 'in-progress', 'finished']);
            $table->integer('progression')->nullable(); // 0-100, ou autre format
            $table->integer('note')->nullable();
            $table->timestamp('added_at')->useCurrent();

            $table->primary(['id_user', 'id_game']);
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_game')->references('id_game')->on('games')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_game');
    }
};
