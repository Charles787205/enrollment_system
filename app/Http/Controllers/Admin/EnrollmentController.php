<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Strand;
use Illuminate\Http\Request;
use App\Models\Student;

class EnrollmentController extends Controller
{
    // Display a listing of the enrollments
    public function index()
    {
        $enrollments = Enrollment::latest()->paginate(10);
        $transferees = Student::where('type', 'transferee')->where('status', 'ENROLLED')->get();

        return view('admin.enrollment.index', compact('enrollments', 'transferees'));
    }

    // Show the form for creating a new enrollment
    public function create()
    {
        $strands = Strand::all();
        return view('admin.enrollment.create', compact('strands'));
    }

    // Store a newly created enrollment in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:50',
            // 'track_or_strand' => 'required|string|max:100',
            'subject' => 'nullable|string|max:255',
            'enrollment_date' => 'required|date',
            'Sex' => 'required|in:Male,Female',
            'DateOfBirth' => 'required|date',
        ]);

        Enrollment::create($validated);

        return redirect()->route('admin.enrollment.index')->with('success', 'Enrollment created successfully.');
    }

    // Show the details of a specific enrollment
    public function show($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return view('admin.enrollment.show', compact('enrollment'));
    }

    // Show the form for editing an existing enrollment
    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $strands = Strand::all();
        return view('admin.enrollment.edit', compact('enrollment', 'strands'));
    }

    // Update an existing enrollment in the database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:50',
            // 'track_or_strand' => 'required|string|max:100',
            'subject' => 'nullable|string|max:255',
            'enrollment_date' => 'required|date',
            'Sex' => 'required|in:Male,Female',
            'DateOfBirth' => 'required|date',
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($validated);

        return redirect()->route('admin.enrollment.index')->with('success', 'Enrollment updated successfully.');
    }

    // Remove a specific enrollment from the database
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('admin.enrollment.index')->with('success', 'Enrollment deleted successfully.');
    }

    // Accept and transfer a transferee to the enrollment list
    public function acceptTransferee($id)
    {
        $transferee = Student::findOrFail($id);

        Enrollment::create([
            'full_name' => $transferee->full_name,
            'grade_level' => $transferee->grade_level,
            // 'track_or_strand' => $transferee->track,
            'subject' => $transferee->subject,
            'enrollment_date' => now(),
            'Sex' => $transferee->Sex,
            'DateOfBirth' => $transferee->DateOfBirth,
        ]);

        $transferee->delete();

        return redirect()->route('admin.enrollment.index')->with('success', 'Transferee moved to enrollments.');
    }
}
