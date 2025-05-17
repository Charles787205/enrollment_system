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
        Schema::table('enrollments', function (Blueprint $table) {
            // Add enrollment_date field first
            $table->date('enrollment_date')->nullable()->after('id');
            
            // Add student relationship
            $table->unsignedBigInteger('student_id')->after('id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            
            // Add subject relationship
            $table->unsignedBigInteger('subject_id')->after('student_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            
            // Add faculty_subject relationship
            $table->unsignedBigInteger('faculty_subject_id')->nullable()->after('subject_id');
            $table->foreign('faculty_subject_id')->references('id')->on('faculty_subjects')->onDelete('set null');
            
            // Add additional fields
            $table->string('academic_year')->after('faculty_subject_id');
            $table->string('semester')->nullable()->after('academic_year');
            $table->enum('status', ['ACTIVE', 'DROPPED', 'COMPLETED'])->default('ACTIVE')->after('enrollment_date');
            $table->string('grade')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['student_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['faculty_subject_id']);
            
            // Drop added columns
            $table->dropColumn([
                'student_id',
                'subject_id',
                'faculty_subject_id',
                'academic_year',
                'semester',
                'enrollment_date',
                'status',
                'grade'
            ]);
        });
    }
};
