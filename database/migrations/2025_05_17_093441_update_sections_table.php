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
        Schema::table('sections', function (Blueprint $table) {
            // Add the basic fields that are missing from the original migration
            $table->string('name')->after('id');
            $table->integer('capacity')->nullable()->after('name');
            
            // Add strand relationship
            $table->unsignedBigInteger('strand_id')->nullable()->after('name');
            $table->foreign('strand_id')->references('id')->on('strands')->onDelete('set null');
            
            // Add grade level field
            $table->enum('grade_level', ['11', '12'])->default('11')->after('strand_id');
            
            // Add room number
            $table->string('room_number')->nullable()->after('capacity');
            
            // Add academic year
            $table->string('academic_year')->nullable()->after('room_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // Remove foreign key constraint
            $table->dropForeign(['strand_id']);
            
            // Drop the added columns
            $table->dropColumn([
                'name',
                'strand_id',
                'grade_level',
                'capacity',
                'room_number',
                'academic_year'
            ]);
        });
    }
};
