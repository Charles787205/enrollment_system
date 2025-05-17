<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_id_file')->nullable();
            $table->string('clearance_file')->nullable();
            $table->string('registration_status')->default('pending');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['student_id_file', 'clearance_file', 'registration_status']);
        });
    }
};