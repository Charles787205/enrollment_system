<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, we'll migrate the existing transferee data to students table
        if (Schema::hasTable('transferees')) {
            $transferees = DB::table('transferees')->get();
            
            foreach ($transferees as $transferee) {
                // Only create a new student record if one doesn't already exist with this email
                $existingStudent = DB::table('students')->where('email', $transferee->email)->first();
                
                if (!$existingStudent) {
                    DB::table('students')->insert([
                        'type' => 'transferee',
                        'student_id' => 'T' . date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                        'first_name' => $transferee->first_name ?? '',
                        'middle_name' => $transferee->middle_name ?? null,
                        'last_name' => $transferee->last_name ?? '',
                        'email' => $transferee->email ?? '',
                        'year_level' => $transferee->grade_level ?? 11,
                        'strand_id' => $transferee->strand_id ?? null,
                        'status' => $transferee->status ?? 'PENDING',
                        'previous_school' => $transferee->previous_school ?? null,
                        'report_card_path' => $transferee->report_card_path ?? null,
                        'good_moral_path' => $transferee->good_moral_path ?? null,
                        'birth_certificate_path' => $transferee->birth_certificate_path ?? null,
                        'created_at' => $transferee->created_at ?? now(),
                        'updated_at' => $transferee->updated_at ?? now(),
                    ]);
                    
                    // Get the newly created student's ID
                    $newStudent = DB::table('students')->where('email', $transferee->email)->first();
                    
                    if ($newStudent) {
                        // Create student details record with address and parent information
                        DB::table('student_details')->insert([
                            'student_id' => $newStudent->id,
                            'street' => $transferee->street_address ?? null,
                            'city' => $transferee->city ?? null,
                            'province' => $transferee->province ?? null,
                            'postal_code' => $transferee->postal_code ?? null,
                            'father_first_name' => isset($transferee->parent_name) ? explode(' ', $transferee->parent_name)[0] ?? null : null,
                            'father_last_name' => isset($transferee->parent_name) ? (count(explode(' ', $transferee->parent_name)) > 1 ? explode(' ', $transferee->parent_name)[1] : null) : null,
                            'guardian_contact_number' => $transferee->parent_guardian_contact ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
        
        // Now drop the transferees table
        Schema::dropIfExists('transferees');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the transferees table structure if it needs to be rolled back
        Schema::create('transferees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('parent_guardian_contact')->nullable();
            $table->string('previous_school');
            $table->string('program');
            $table->enum('grade_level', ['11', '12'])->default('11');
            $table->enum('status', ['PENDING', 'ENROLLED', 'PASSED', 'FAILED'])->default('PENDING');
            $table->string('academic_year');
            $table->unsignedBigInteger('strand_id')->nullable();
            $table->string('report_card_path')->nullable();
            $table->string('good_moral_path')->nullable();
            $table->string('birth_certificate_path')->nullable();
            $table->timestamps();
            
            $table->foreign('strand_id')->references('id')->on('strands')->onDelete('set null');
        });
        
        // Note: This migration cannot restore the data that was in the transferees table
        // It only recreates the structure
    }
};
