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
        
    Schema::create('training_programs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('coach_id');
    $table->unsignedBigInteger('athlete_id');
    $table->unsignedBigInteger('sport_id');
    $table->timestamps();

    $table->foreign('coach_id')->references('id')->on('coaches')->onDelete('cascade');
    $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
    $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
});



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
