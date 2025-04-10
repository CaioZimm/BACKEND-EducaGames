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
        Schema::create('game', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->enum('mode', ['competitive', 'casual']);
            $table->date('closed_time')->nullable();
            $table->string('password')->nullable();
            $table->decimal('max_score', 4,2)->nullable();
            $table->unsignedBigInteger('foundation_id');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            // Relation about Foundation Table;
            $table->foreign('foundation_id')->references('id')->on('foundation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game');
    }
};
