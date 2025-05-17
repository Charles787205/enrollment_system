<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\Strand;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;

class OldStudentController extends Controller
{
    /**
     * Display a listing of old students.
     */
    public function index()
    {
        $students = Student::where('type', 'old')->with('strand', 'details')->get();
        return view('admin.old_students.index', compact('students'));
    }

    /**
     * Display a listing of old students separated by grade level.
     */
    public function gradeLevel($level)
    {
        $students = Student::where('type', 'old')
                         ->where('year_level', $level)
                         ->with('strand', 'details')
                         ->get();
        return view('admin.old_students.grade_level', compact('students', 'level'));
    }

    /**
     * Show the form for creating a new old student.
     */
    public function create()
    {
        $strands = Strand::all();
        return view('admin.old_students.create', compact('strands'));
    }

    /**
     * Store a newly created old student in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'contact_number' => 'required|string|max:20',
            'previous_school' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'year_level' => 'required|in:11,12',
            'strand_id' => 'required|exists:strands,id',
            'parent_name' => 'required|string|max:255',
            'parent_guardian_contact' => 'required|string|max:20',
            'status' => 'required|string',
            'Sex' => 'required|in:Male,Female',
            // Address fields
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new student record
        $student = Student::create([
            'type' => 'old',
            'student_id' => 'O' . date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'year_level' => $request->year_level,
            'strand_id' => $request->strand_id,
            'status' => $request->status,
            'Sex' => $request->Sex,
            'previous_school' => $request->previous_school,
            'PhoneNumber' => $request->contact_number,
            'EnrollmentDate' => now(),
        ]);
        
        // Create student details record
        StudentDetail::create([
            'student_id' => $student->id,
            'street' => $request->street,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'father_first_name' => explode(' ', $request->parent_name)[0] ?? null,
            'father_last_name' => count(explode(' ', $request->parent_name)) > 1 ? explode(' ', $request->parent_name)[1] : null,
            'guardian_contact_number' => $request->parent_guardian_contact,
        ]);

        return redirect()->route('admin.old_students.index')
            ->with('success', 'Old student added successfully.');
    }

    /**
     * Display the specified old student.
     */
    public function show($id)
    {
        $student = Student::where('type', 'old')->with('strand', 'details')->findOrFail($id);
        return view('admin.old_students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified old student.
     */
    public function edit($id)
    {
        $student = Student::where('type', 'old')->with('details')->findOrFail($id);
        $strands = Strand::all();
        return view('admin.old_students.edit', compact('student', 'strands'));
    }

    /**
     * Update the specified old student in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'contact_number' => 'required|string|max:20',
            'previous_school' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'year_level' => 'required|in:11,12',
            'strand_id' => 'required|exists:strands,id',
            'parent_name' => 'required|string|max:255',
            'parent_guardian_contact' => 'required|string|max:20',
            // Address fields
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Student::where('type', 'old')->findOrFail($id);
        
        // Update student record
        $student->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'year_level' => $request->year_level,
            'strand_id' => $request->strand_id,
            'previous_school' => $request->previous_school,
            'PhoneNumber' => $request->contact_number,
        ]);
        
        // Update or create student details
        if ($student->details) {
            $student->details->update([
                'street' => $request->street,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'father_first_name' => explode(' ', $request->parent_name)[0] ?? null,
                'father_last_name' => count(explode(' ', $request->parent_name)) > 1 ? explode(' ', $request->parent_name)[1] : null,
                'guardian_contact_number' => $request->parent_guardian_contact,
            ]);
        } else {
            StudentDetail::create([
                'student_id' => $student->id,
                'street' => $request->street,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'father_first_name' => explode(' ', $request->parent_name)[0] ?? null,
                'father_last_name' => count(explode(' ', $request->parent_name)) > 1 ? explode(' ', $request->parent_name)[1] : null,
                'guardian_contact_number' => $request->parent_guardian_contact,
            ]);
        }

        return redirect()->route('admin.old_students.index')
            ->with('success', 'Old student updated successfully.');
    }

    /**
     * Remove the specified old student from storage.
     */
    public function destroy($id)
    {
        $student = Student::where('type', 'old')->findOrFail($id);
        
        // Delete related details
        if ($student->details) {
            $student->details->delete();
        }
        
        // Delete student record
        $student->delete();

        return redirect()->route('admin.old_students.index')
            ->with('success', 'Old student deleted successfully.');
    }

    /**
     * Promote grade 11 students to grade 12.
     */
    public function promoteStudents(Request $request)
    {
        $studentsToPromote = $request->input('student_ids', []);
        
        $count = 0;
        foreach ($studentsToPromote as $studentId) {
            $student = Student::findOrFail($studentId);
            if ($student->year_level == '11' && $student->status == 'PASSED') {
                $student->year_level = '12';
                $student->status = 'ENROLLED';
                $student->save();
                $count++;
            }
        }
        
        return redirect()->back()
            ->with('success', $count . ' students promoted to Grade 12 successfully.');
    }

    /**
     * Mark students as passed.
     */
    public function markAsPassed(Request $request)
    {
        $studentIds = $request->input('student_ids', []);
        
        $count = 0;
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);
            $student->status = 'PASSED';
            $student->save();
            $count++;
        }
        
        return redirect()->back()
            ->with('success', $count . ' students marked as PASSED successfully.');
    }
}
