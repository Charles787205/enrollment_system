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
            // Add a 'type' field to distinguish between old students and transferees
            $table->enum('type', ['old', 'transferee'])->default('old')->after('student_id');
            
            // Add previous_school field (moved from transferees)
            $table->string('previous_school')->nullable()->after('status');

            // Add field for storing report card, good moral and birth certificate paths (for transferees)
            $table->string('report_card_path')->nullable()->after('previous_school');
            $table->string('good_moral_path')->nullable()->after('report_card_path');
            $table->string('birth_certificate_path')->nullable()->after('good_moral_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('previous_school');
            $table->dropColumn('report_card_path');
            $table->dropColumn('good_moral_path');
            $table->dropColumn('birth_certificate_path');
        });
    }
};
