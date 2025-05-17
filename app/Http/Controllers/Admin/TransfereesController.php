<?php


    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Transferee;
    use App\Models\Enrollment;
    use Illuminate\Support\Carbon;
    use App\Models\Subject;

    
    class TransfereesController extends Controller
    {
        // Existing index function
        public function index(Request $request)
        {
            $query = Transferee::query();
    
            // Search by name or previous school
            if ($request->has('search') && $request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('full_name', 'like', '%' . $request->search . '%')
                      ->orWhere('previous_school', 'like', '%' . $request->search . '%');
                });
            }
    
            // Filter by program (strand)
            if ($request->has('program') && $request->program) {
                $query->where('program', $request->program);
            }
    
            // Paginate transferees
            $transferees = $query->paginate(8);
    
            // Distinct list of programs to populate filter dropdown
            $availablePrograms = Transferee::select('program')->distinct()->pluck('program');
    
            return view('admin.transferees.index', compact('transferees', 'availablePrograms'));
        }
    
        // Enroll a transferee
        public function enroll($id)
        {
            $transferee = Transferee::findOrFail($id);
        
            if ($transferee->status === 'enrolled') {
                return redirect()->route('admin.transferees.index')->with('info', 'This transferee is already enrolled.');
            }
        

            // Fetch subjects based on transferee's program and grade level
            // $subjects = Subject::where('Strand', $transferee->program)
            //                     ->where('YearLevel', $transferee->grade_level)
            //                     // ->pluck('SubjectName')
            //                     // ->toArray();
        
            // $subjectList = implode(', ', $subjects); // Join subjects into a single string
        
            // Update transferee status to 'enrolled'
            $transferee->status = 'enrolled';
            $transferee->save();
        
            // Create the enrollment record
            Enrollment::create([
                'full_name'       => $transferee->full_name,
                'academic_year'     => $transferee->academic_year,
                // 'grade_level'     => $transferee->grade_level,
                // 'track'           => $transferee->program,
                // 'subject'         => $subjectList,
                // 'enrollment_date' => Carbon::now(),
                // 'status'          => 'enrolled',
            ]);
        
            return redirect()->route('admin.transferees.index')->with('success', 'Transferee enrolled successfully.');
        }
    }    