<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('checklist_responses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('checklist_item_id')->constrained()->onDelete('cascade');
        $table->foreignId('athlete_id')->constrained()->onDelete('cascade');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_responses');
    }
};
