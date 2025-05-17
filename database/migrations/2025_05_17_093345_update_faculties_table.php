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
        Schema::table('faculties', function (Blueprint $table) {
            // Add the basic fields that are missing from the original migration
            $table->string('name')->after('id');
            $table->string('gender')->nullable()->after('name');
            $table->string('email')->nullable()->after('gender');
            $table->string('position')->nullable()->after('email');
            $table->string('contact_number')->nullable()->after('position');
            
            // Split name into components
            $table->string('first_name')->nullable()->after('contact_number');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            
            // Add address and specialty fields
            $table->string('address')->nullable()->after('last_name');
            $table->string('specialty')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            // Drop added columns
            $table->dropColumn([
                'name',
                'gender',
                'email',
                'position',
                'contact_number',
                'first_name',
                'middle_name',
                'last_name',
                'address',
                'specialty'
            ]);
        });
    }
};
