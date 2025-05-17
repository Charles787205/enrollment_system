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
        Schema::table('subjects', function (Blueprint $table) {
            // Add strand relationship
            $table->unsignedBigInteger('strand_id')->nullable()->after('grade_level');
            $table->foreign('strand_id')->references('id')->on('strands')->onDelete('set null');
            
            // Add additional subject information
            $table->integer('units')->default(3)->after('strand_id');
            $table->integer('hours_per_week')->default(3)->after('units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Remove foreign key constraint
            $table->dropForeign(['strand_id']);
            
            // Remove added columns
            $table->dropColumn(['strand_id', 'units', 'hours_per_week']);
        });
    }
};
