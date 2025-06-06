<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Strand;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query();

        // Filter by search term (name or student ID)
        if ($request->filled('search')) {
            $students->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%')
                      ->orWhere('last_name', 'like', '%' . $request->search . '%')
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

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:20|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'contact_number' => 'nullable|string|max:20',
            'year_level' => 'required|in:11,12',
            'strand_id' => 'required|exists:strands,id',
            'status' => 'required|string',
            'Sex' => 'required|in:Male,Female',
            'DateOfBirth' => 'nullable|date',
            'type' => 'required|in:old,transferee',
            'Address' => 'nullable|string|max:255',
            'SubjectsTaken' => 'nullable|string',
            'clearance_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            $student = new Student();
            $student->student_id = $validated['student_id'];
            $student->first_name = $validated['first_name'];
            $student->middle_name = $validated['middle_name'];
            $student->last_name = $validated['last_name'];
            $student->email = $validated['email'];
            $student->contact_number = $request->input('contact_number');
            $student->year_level = $validated['year_level'];
            $student->strand_id = $validated['strand_id'];
            $student->status = $validated['status'];
            $student->Sex = $validated['Sex'];
            $student->DateOfBirth = $validated['DateOfBirth'];
            $student->type = $validated['type'];
            $student->Address = $request->input('Address');
            $student->SubjectsTaken = $request->input('SubjectsTaken');

            // Store clearance file if exists
            if ($request->hasFile('clearance_file')) {
                $path = $request->file('clearance_file')->store('clearances', 'public');
                $student->grade_file_url = $path;
            }

            $student->save();
            
            // Create student details if form contains related fields
            if ($request->filled('street') || $request->filled('barangay') || 
                $request->filled('city') || $request->filled('father_first_name')) {
                $studentDetails = new StudentDetail();
                $studentDetails->student_id = $student->id;
                $studentDetails->street = $request->input('street');
                $studentDetails->barangay = $request->input('barangay');
                $studentDetails->city = $request->input('city');
                $studentDetails->province = $request->input('province');
                $studentDetails->postal_code = $request->input('postal_code');
                
                // Parent information
                $studentDetails->father_first_name = $request->input('father_first_name');
                $studentDetails->father_middle_name = $request->input('father_middle_name');
                $studentDetails->father_last_name = $request->input('father_last_name');
                $studentDetails->father_contact_number = $request->input('father_contact_number');
                $studentDetails->father_occupation = $request->input('father_occupation');
                
                $studentDetails->mother_first_name = $request->input('mother_first_name');
                $studentDetails->mother_middle_name = $request->input('mother_middle_name');
                $studentDetails->mother_last_name = $request->input('mother_last_name');
                $studentDetails->mother_contact_number = $request->input('mother_contact_number');
                $studentDetails->mother_occupation = $request->input('mother_occupation');
                
                $studentDetails->guardian_first_name = $request->input('guardian_first_name');
                $studentDetails->guardian_last_name = $request->input('guardian_last_name');
                $studentDetails->guardian_contact_number = $request->input('guardian_contact_number');
                $studentDetails->guardian_relationship = $request->input('guardian_relationship');
                
                $studentDetails->save();
            }

            return redirect()->route('admin.students.index')
                ->with('success', 'Student created successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create student. Please try again. ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'DateOfBirth' => 'nullable|date',
            'Sex' => 'required|in:Male,Female',
            'email' => 'required|email|unique:students,email,' . $id,
            'contact_number' => 'nullable|string|max:20',
            'Address' => 'nullable|string|max:255',
            'year_level' => 'required|in:11,12',
            'strand_id' => 'required|exists:strands,id',
            'status' => 'required|string',
            'previous_school' => 'nullable|string|max:255',
            'SubjectsTaken' => 'nullable|string',
            'clearance_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            $student->first_name = $validated['first_name'];
            $student->middle_name = $validated['middle_name'];
            $student->last_name = $validated['last_name'];
            $student->DateOfBirth = $validated['DateOfBirth'];
            $student->Sex = $validated['Sex'];
            $student->email = $validated['email'];
            $student->contact_number = $request->input('contact_number');
            // Fix for Address field - use request input instead of validated data
            $student->Address = $request->input('Address');
            $student->year_level = $validated['year_level'];
            $student->strand_id = $validated['strand_id'];
            $student->status = $validated['status'];
            $student->previous_school = $request->input('previous_school');
            // Use request input for SubjectsTaken to avoid error if not in validated data
            $student->SubjectsTaken = $request->input('SubjectsTaken');

            // Store clearance file if exists
            if ($request->hasFile('clearance_file')) {
                $path = $request->file('clearance_file')->store('clearances', 'public');
                $student->grade_file_url = $path;
            }

            $student->save();
            
            // Update or create student details
            if ($request->filled('street') || $request->filled('barangay') || 
                $request->filled('city') || $request->filled('father_first_name')) {
                
                // Get or create student details
                $studentDetails = $student->details ?? new \App\Models\StudentDetail(['student_id' => $student->id]);
                
                // Update address information
                $studentDetails->street = $request->input('street');
                $studentDetails->barangay = $request->input('barangay');
                $studentDetails->city = $request->input('city');
                $studentDetails->province = $request->input('province');
                $studentDetails->postal_code = $request->input('postal_code');
                
                // Update parent information
                $studentDetails->father_first_name = $request->input('father_first_name');
                $studentDetails->father_middle_name = $request->input('father_middle_name');
                $studentDetails->father_last_name = $request->input('father_last_name');
                $studentDetails->father_contact_number = $request->input('father_contact_number');
                $studentDetails->father_occupation = $request->input('father_occupation');
                
                $studentDetails->mother_first_name = $request->input('mother_first_name');
                $studentDetails->mother_middle_name = $request->input('mother_middle_name');
                $studentDetails->mother_last_name = $request->input('mother_last_name');
                $studentDetails->mother_contact_number = $request->input('mother_contact_number');
                $studentDetails->mother_occupation = $request->input('mother_occupation');
                
                $studentDetails->guardian_first_name = $request->input('guardian_first_name');
                $studentDetails->guardian_last_name = $request->input('guardian_last_name');
                $studentDetails->guardian_contact_number = $request->input('guardian_contact_number');
                $studentDetails->guardian_relationship = $request->input('guardian_relationship');
                
                // Save student details
                if (!$studentDetails->exists) {
                    $studentDetails->student_id = $student->id;
                }
                $studentDetails->save();
            }

            return redirect()->route('admin.students.index')
                ->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update student. Please try again. ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function dashboard()
    {
        $stats = [
            'total_students' => Student::count(),
            'old_students' => Student::where('status', 'Old')->count(),
            'transferees' => Student::where('status', 'Transferee')->count(),
            'total_strands' => Strand::count(),
            'faculty_members' => Faculty::count(),
        ];
    
        $chartData = Student::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    
        // Prepare chart data for all 12 months
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $chartData[$i] ?? 0;
        }
    
        // Updated to use split name fields
        $allStudents = Student::select('first_name', 'middle_name', 'last_name', 'course', 'year_level')->get();
    
        return view('admin.dashboard', [
            'stats' => $stats,
            'chartData' => $monthlyData,
            'allStudents' => $allStudents,
        ]);
    }
}
