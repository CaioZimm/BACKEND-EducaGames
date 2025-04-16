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
        Schema::create('question', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('type', ['open', 'mult']);
            $table->integer('score');
            $table->unsignedBigInteger('game_id');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            // Relation about Game Table;
            $table->foreign('game_id')->references('id')->on('game');
        });

        Schema::create('alternative', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('is_correct', ['true', 'false']);
            $table->unsignedBigInteger('question_id');
            $table->timestamps();

            // Relation about Question Table;
            $table->foreign('question_id')->references('id')->on('question');
        });

        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('is_correct', ['waiting', 'correct', 'wrong', 'partially']);
            $table->unsignedBigInteger('alternative_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->unique(['user_id', 'question_id']);
            $table->timestamps();

            // Relations about Option, Question, User Tables;
            $table->foreign('alternative_id')->references('id')->on('alternative');
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('question_id')->references('id')->on('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer');
        Schema::dropIfExists('alternative');
        Schema::dropIfExists('question');
    }
};
