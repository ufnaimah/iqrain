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
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id('leaderboard_id');
            $table->unsignedBigInteger('murid_id')->unique();
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->integer('total_poin_semua_game')->default(0);
            $table->integer('ranking_global')->default(0);
            $table->integer('ranking_mentor')->default(0);
            $table->timestamps();

            $table->foreign('murid_id')->references('murid_id')->on('murids')->onDelete('cascade');
            $table->foreign('mentor_id')->references('mentor_id')->on('mentors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};
