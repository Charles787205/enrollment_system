<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OldStudentController extends Controller
{
    public function verifyForm()
    {
        return view('verify');
    }

    public function verifyStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|min:5'
        ]);

        $student = Student::where('student_id', $request->student_id)->first();

        if ($student) {
            Session::put('verified_student_id', $student->student_id);
            Session::put('student_data', $student);
            return response()->json([
                'found' => true,
                'student' => $student
            ]);
        }

        return response()->json(['found' => false]);
    }

    public function showRegistrationForm()
    {
        if (!Session::has('verified_student_id')) {
            return redirect()->route('verify');
        }

        $student = Session::get('student_data');
        $strands = ['STEM', 'ABM'];
        return view('old-student', compact('student', 'strands'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'clearance_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            // Upload the clearance file
            $clearancePath = $request->file('clearance_file')->store('student-documents', 'public');

            // Find the student record
            $student = Student::where('student_id', $request->student_id)->first();

            if (!$student) {
                return back()->with('error', 'Student not found.');
            }

            // Update the student record with the clearance file path
            $student->update([
                'grade_file_url' => $clearancePath,
            ]);

            // Stay on the same page with a success message
            return back()->with('success', 'Registration completed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading files. Please try again.');
        }
    }

    public function registerOldStudent(Request $request)
    {
        // Validation logic for the form
        $request->validate([
            'clearance_file' => 'required|mimes:pdf,jpeg,jpg,png|max:2048',
            // other fields validation...
        ]);

        // Assuming you're updating the student record or creating new ones
        $student = Student::where('student_id', Session::get('verified_student_id'))->first();

        if (!$student) {
            return redirect()->route('verify')->with('error', 'No verified student found.');
        }

        try {
            // Handle file upload
            $clearancePath = $request->file('clearance_file')->store('student-documents', 'public');

            // Update the student's record with the clearance file path
            $student->update([
                'clearance_file_path' => $clearancePath,
            ]);

            session()->flash('success', 'Registration successful!');
            return redirect()->route('old-student.form');
        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading the file. Please try again.');
        }
    }

    public function showSuccessMessage()
    {
        return view('registration-success');
    }

    public function showErrorMessage()
    {
        return view('registration-error');
    }
}
