<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentsController extends Controller
{
    // Method to update a student's information
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id); // Fetch the student by ID

        // Validate the input data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'year_level' => 'required|integer|in:11,12',
            'status' => 'required|string|in:Active,Inactive,Pending',
            'strand' => 'required|string|in:STEM,ABM,HUMSS',
            'clearance_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle student ID file upload if exists
        if ($request->hasFile('student_id_file')) {
            // Delete old file if exists
            if ($student->student_id_file_path) {
                Storage::disk('public')->delete($student->student_id_file_path);
            }
            // Store the new file and save the path
            $validated['student_id_file_path'] = $request->file('student_id_file')->store('student-documents', 'public');
        }

        // Handle clearance file upload if exists
        if ($request->hasFile('clearance_file')) {
            // Delete old file if exists
            if ($student->grade_file_url) {
                Storage::disk('public')->delete($student->grade_file_url);
            }
            // Store the new clearance file and save the path
            $validated['grade_file_url'] = $request->file('clearance_file')->store('student-documents', 'public');
        }

        // Update the student's record with validated data
        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    // Method to register an old student
    public function registerOldStudent(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'year_level' => 'required|integer|in:11,12',
            'email' => 'required|email|unique:students,email',
            'strand' => 'required|string|in:STEM,ABM,HUMSS',
            'clearance_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        // Handle the clearance file upload
        if ($request->hasFile('clearance_file')) {
            // Store the file in 'student-documents' folder
            $path = $request->file('clearance_file')->store('student-documents', 'public');
            $validated['grade_file_url'] = $path; // Save the file path to $validated array
        }
    
        // Create a new Student record
        Student::create($validated);
    
        return redirect()->route('registration.success')
            ->with('success', 'Registration submitted successfully. Please wait for approval.');
    }
    
}
