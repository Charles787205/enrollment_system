<?php


    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Student;
    use App\Models\Enrollment;
    use Illuminate\Support\Carbon;
    use App\Models\Subject;

    
    class TransfereesController extends Controller
    {
        // Updated index function to use Student model with type=transferee
        public function index(Request $request)
        {
            $query = Student::where('type', 'transferee');
    
            // Search by name or previous school
            if ($request->has('search') && $request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search . '%')
                      ->orWhere('last_name', 'like', '%' . $request->search . '%')
                      ->orWhere('previous_school', 'like', '%' . $request->search . '%');
                });
            }
    
            // Filter by strand
            if ($request->has('strand_id') && $request->strand_id) {
                $query->where('strand_id', $request->strand_id);
            }
    
            // Paginate transferees
            $transferees = $query->with('strand', 'details')->paginate(8);
    
            // Get available strands for filter dropdown
            $availableStrands = \App\Models\Strand::all();
    
            return view('admin.transferees.index', compact('transferees', 'availableStrands'));
        }
    
        // Enroll a transferee
        public function enroll($id)
        {
            $transferee = Student::where('type', 'transferee')->findOrFail($id);
        
            if ($transferee->status === 'ENROLLED') {
                return redirect()->route('admin.transferees.index')->with('info', 'This transferee is already enrolled.');
            }
        
            // Update transferee status to 'ENROLLED'
            $transferee->status = 'ENROLLED';
            $transferee->save();
            
            // Get the subjects associated with the transferee's strand
            $subjects = $transferee->strand->subjects;
            
            if ($subjects->isEmpty()) {
                // If no subjects are found, redirect with an error message
                return redirect()->route('admin.transferees.index')->with('error', 'No subjects found for this strand. Please assign subjects to the strand first.');
            }
            
            // Create enrollment records for each subject
            foreach ($subjects as $subject) {
                Enrollment::create([
                    'student_id' => $transferee->id,
                    'subject_id' => $subject->id,
                    'academic_year' => date('Y') . '-' . (date('Y') + 1),
                    'enrollment_date' => Carbon::now(),
                    'status' => 'ACTIVE',
                ]);
            }
        
            return redirect()->route('admin.transferees.index')->with('success', 'Transferee enrolled successfully.');
        }
    }