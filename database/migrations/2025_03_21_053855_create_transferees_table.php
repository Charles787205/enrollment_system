<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transferees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('previous_school');
            $table->string('program');
            $table->string('academic_year');
            $table->text('additional_info')->nullable();
            $table->string('report_card_path')->nullable();
            $table->string('good_moral_path')->nullable();
            $table->string('birth_certificate_path')->nullable(); // Changed from Birth_certificate_path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferees');
    }
};