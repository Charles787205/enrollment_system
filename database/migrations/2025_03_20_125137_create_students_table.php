<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('Address')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('parent_guardian_contact')->nullable();
            $table->integer('year_level');
            $table->unsignedBigInteger('strand_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('grade_file_url')->nullable();
            $table->date('DateOfBirth')->nullable();
            $table->enum('Sex', ['Male', 'Female'])->nullable();
            $table->timestamp('EnrollmentDate')->nullable();
            $table->text('SubjectsTaken')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};