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
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id');
            $table->string('field_name');
            $table->string('field_type');
            $table->text('options')->nullable();
            $table->integer('minimum_threshold')->nullable();
            $table->integer('maximum_threshold')->nullable();
            $table->boolean('is_required');
            $table->timestamps();

            // Define foreign key relationships
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};
