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
            $table->string('father_name');  // New field for father's name
            $table->string('father_contact');  // New field for father's contact
            $table->string('mother_name');  // New field for mother's name
            $table->string('mother_contact');  // New field for mother's contact
            $table->string('previous_school');
            $table->string('program');
            $table->string('academic_year');
            $table->text('additional_info')->nullable();
            $table->string('report_card_path')->nullable();
            $table->string('good_moral_path')->nullable();
            $table->string('birth_certificate_path')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferees');
    }
};