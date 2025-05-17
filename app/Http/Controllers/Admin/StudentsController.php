<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentsController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query();

        // Filter by search term (name or student ID)
        if ($request->filled('search')) {
            $students->where(function ($query) use ($request) {
                $query->where('full_name', 'like', '%' . $request->search . '%')
                      ->orWhere('student_id', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by year level
        if ($request->filled('year_level')) {
            $students->where('year_level', $request->year_level);
        }

        // Filter by status
        if ($request->filled('status')) {
            $students->where('status', $request->status);
        }

        // Filter by strand_id
        if ($request->filled('strand_id')) {
            $students->where('strand_id', $request->strand_id);
        }

        // Paginate results with the filter parameters retained
        $students = $students->paginate(10)->appends($request->except('page'));

        return view('admin.students.index', compact('students'));
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'year_level' => 'required|in:11,12',
            'status' => 'required|string',
            'strand_id' => 'required|exists:strands,id',
            'Sex' => 'required|in:Male,Female',
            'student_id' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'Address' => 'nullable|string|max:255',
            
        ]);

        // Create a new student and fill its fields
        $student = new Student();
        $student->first_name = $request->input('first_name');
        $student->middle_name = $request->input('middle_name');
        $student->last_name = $request->input('last_name');
        $student->email = $request->input('email');
        $student->year_level = $request->input('year_level');
        $student->status = $request->input('status');
        $student->strand_id = $request->input('strand_id');
       
        $student->Address = $request->input('Address');
       
        $student->Sex = $request->input('Sex');
        $student->student_id = $request->input('student_id');

        

        // Save student
        $student->save();

        // Redirect to the index with success message
        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully!');
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'year_level' => 'required|in:11,12',
            'status' => 'required|string',
            'strand_id' => 'required|exists:strands,id',
            'Sex' => 'required|in:Male,Female',
            'phone' => 'nullable|string|max:15',
            'Address' => 'nullable|string|max:255',
            'SubjectsTaken' => 'nullable|string',
            'clearance_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Find and update the student record
        $student = Student::findOrFail($id);
        $student->first_name = $request->input('first_name');
        $student->middle_name = $request->input('middle_name');
        $student->last_name = $request->input('last_name');
        $student->email = $request->input('email');
        $student->year_level = $request->input('year_level');
        $student->status = $request->input('status');
        $student->strand_id = $request->input('strand_id');
        $student->PhoneNumber = $request->input('phone');
        $student->Address = $request->input('Address');
        $student->SubjectsTaken = $request->input('SubjectsTaken');
        $student->Sex = $request->input('Sex');

        // Store clearance file if exists
        if ($request->hasFile('clearance_file')) {
            $path = $request->file('clearance_file')->store('clearances', 'public');
            $student->grade_file_url = $path;
        }

        // Save updated student
        $student->save();

        // Redirect to the index with success message
        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the student and delete
        $student = Student::findOrFail($id);
        $student->delete();

        // Redirect to the index with success message
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}