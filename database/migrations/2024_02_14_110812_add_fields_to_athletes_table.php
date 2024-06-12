<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAthletesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female', 'N/A', 'Others'])->nullable();
            $table->char('blood_type')->nullable();
            $table->float('bmi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('blood_type');
            $table->dropColumn('bmi');
        });
    }
}
