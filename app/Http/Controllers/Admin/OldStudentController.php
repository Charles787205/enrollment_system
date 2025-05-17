<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transferee;
use App\Models\Student;
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
        $transferees = Transferee::with('strand')->get();
        return view('admin.old_students.index', compact('transferees'));
    }

    /**
     * Display a listing of old students separated by grade level.
     */
    public function gradeLevel($level)
    {
        $transferees = Transferee::where('grade_level', $level)->with('strand')->get();
        return view('admin.old_students.grade_level', compact('transferees', 'level'));
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
            'email' => 'required|email|unique:transferees,email',
            'contact_number' => 'required|string|max:20',
            'previous_school' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'grade_level' => 'required|in:11,12',
            'strand_id' => 'required|exists:strands,id',
            'parent_name' => 'required|string|max:255',
            'parent_guardian_contact' => 'required|string|max:20',
            'status' => 'required|string',
            'Sex' => 'required|in:Male,Female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $transferee = Transferee::create($request->all());

        return redirect()->route('admin.old_students.index')
            ->with('success', 'Old student added successfully.');
    }

    /**
     * Display the specified old student.
     */
    public function show($id)
    {
        $transferee = Transferee::with('strand')->findOrFail($id);
        return view('admin.old_students.show', compact('transferee'));
    }

    /**
     * Show the form for editing the specified old student.
     */
    public function edit($id)
    {
        $transferee = Transferee::findOrFail($id);
        $strands = Strand::all();
        return view('admin.old_students.edit', compact('transferee', 'strands'));
    }

    /**
     * Update the specified old student in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:transferees,email,' . $id,
            'contact_number' => 'required|string|max:20',
            'previous_school' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'grade_level' => 'required|in:11,12',
            'strand_id' => 'required|exists:strands,id',
            'parent_name' => 'required|string|max:255',
            'parent_guardian_contact' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $transferee = Transferee::findOrFail($id);
        $transferee->update($request->all());

        return redirect()->route('admin.old_students.index')
            ->with('success', 'Old student updated successfully.');
    }

    /**
     * Remove the specified old student from storage.
     */
    public function destroy($id)
    {
        $transferee = Transferee::findOrFail($id);
        $transferee->delete();

        return redirect()->route('admin.old_students.index')
            ->with('success', 'Old student deleted successfully.');
    }

    /**
     * Approve a transferee and create a student account.
     */
    public function approve($id)
    {
        $transferee = Transferee::findOrFail($id);
        
        // Generate a student ID
        $studentId = 'ST' . date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        // Create a new student record
        $student = new Student([
            'student_id' => $studentId,
            'first_name' => $transferee->first_name,
            'middle_name' => $transferee->middle_name,
            'last_name' => $transferee->last_name,
            'email' => $transferee->email,
            'street_address' => $transferee->street_address,
            'city' => $transferee->city,
            'province' => $transferee->province,
            'postal_code' => $transferee->postal_code,
            'parent_name' => $transferee->parent_name,
            'guardian_name' => $transferee->guardian_name,
            'parent_guardian_contact' => $transferee->parent_guardian_contact,
            'year_level' => $transferee->grade_level,
            'strand_id' => $transferee->strand_id,
            'status' => 'ENROLLED',
            'PhoneNumber' => $transferee->contact_number,
            'EnrollmentDate' => now()
        ]);
        
        $student->save();
        
        // Update transferee status
        $transferee->status = 'ENROLLED';
        $transferee->save();
        
        return redirect()->route('admin.old_students.index')
            ->with('success', 'Transferee approved and student account created successfully.');
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
