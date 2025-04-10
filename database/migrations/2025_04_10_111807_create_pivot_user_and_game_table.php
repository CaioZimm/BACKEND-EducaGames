<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('result', function (Blueprint $table) {
            $table->id();
            $table->decimal('your_score', 4,2);
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Relation about Game and User Tables;
            $table->foreign('game_id')->references('id')->on('game');
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result');
    }
};
