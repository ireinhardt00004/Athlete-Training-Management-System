<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable()->default('');
            $table->unsignedBigInteger('coach_id');
            $table->unsignedBigInteger('material_id'); 
             $table->timestamps();
            // Define foreign key relationships
            $table->foreign('coach_id')->references('id')->on('coaches')->onDelete('cascade');
            // Define foreign key relationships
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
