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
        Schema::table('user', function (Blueprint $table) {
            // Relation about Foundation and Avatar Tables;
            $table->foreign('avatar_id')->references('id')->on('avatar');
            $table->foreign('foundation_id')->references('id')->on('foundation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropForeign(['foundation_id']);
            $table->dropForeign(['avatar_id']);
        });
    }
};
