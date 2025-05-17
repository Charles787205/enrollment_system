<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::create([
            'student_id' => '2024-0001',
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'strand' => 'STEM',
            'year_level' => 11,
            'STATUS' => 'PASSED',
            'PhoneNumber' => '1234567890',
            'ADDRESS' => '123 Main St',
            'DateOfBirth' => '2000-01-01',
            'Gender' => 'Male',
            'SubjectsTaken' => 'Math, Science, English',
        ]);
    }
}