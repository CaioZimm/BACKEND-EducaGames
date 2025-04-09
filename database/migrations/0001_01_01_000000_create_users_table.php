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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('password');
            $table->unsignedBigInteger('avatar_id');
            $table->unsignedBigInteger('foundation_id');
            $table->softDeletes('deleted_at');
            $table->rememberToken();
            $table->timestamps();

            // Relation about tables;
            // $table->foreign('avatar_id')->references('id')->on('avatar');
            // $table->foreign('foundation_id')->references('id')->on('foundation');
        });

        // Schema::create('avatar', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('url')->comment('Avatares do usuário');
        // });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
        // Schema::dropIfExists('avatar');
        Schema::dropIfExists('sessions');
    }
};
