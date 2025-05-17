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
        Schema::table('transferees', function (Blueprint $table) {
            // Drop the full_name column
            $table->dropColumn('full_name');
            
            // Add the split name fields
            $table->string('first_name')->after('id');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->after('middle_name');
            
            // Add address fields
            $table->string('street_address')->nullable()->after('contact_number');
            $table->string('city')->nullable()->after('street_address');
            $table->string('province')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('province');
            
            // Add parent and guardian information
            $table->string('parent_name')->nullable()->after('postal_code');
            $table->string('guardian_name')->nullable()->after('parent_name');
            $table->string('parent_guardian_contact')->nullable()->after('guardian_name');
            
            // Add grade level and status for promotion tracking
            $table->enum('grade_level', ['11', '12'])->default('11')->after('program');
            $table->enum('status', ['PENDING', 'ENROLLED', 'PASSED', 'FAILED'])->default('PENDING')->after('grade_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transferees', function (Blueprint $table) {
            // Add back the full_name column
            $table->string('full_name')->after('id');
            
            // Drop the added columns
            $table->dropColumn([
                'first_name',
                'middle_name',
                'last_name',
                'street_address',
                'city',
                'province',
                'postal_code',
                'parent_name',
                'guardian_name',
                'parent_guardian_contact',
                'grade_level',
                'status'
            ]);
        });
    }
};
