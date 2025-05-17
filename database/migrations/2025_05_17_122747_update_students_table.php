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
        Schema::table('students', function (Blueprint $table) {
            // Add the Sex field if it doesn't exist
            if (!Schema::hasColumn('students', 'Sex')) {
                $table->enum('Sex', ['Male', 'Female'])->nullable()->after('email');
            }
            
            // Add the status field if it doesn't exist
            if (!Schema::hasColumn('students', 'status')) {
                $table->string('status')->default('PENDING')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the columns if they exist
            if (Schema::hasColumn('students', 'Sex')) {
                $table->dropColumn('Sex');
            }
            
            if (Schema::hasColumn('students', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
