<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventIdToMaterialsTable extends Migration
{
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            // Add event_id column as an unsigned integer
            $table->unsignedBigInteger('event_id')->nullable();
            
            // Add foreign key constraint
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            // Drop the event_id column if the migration is rolled back
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
}

