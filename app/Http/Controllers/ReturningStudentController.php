<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\Strand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReturningStudentController extends Controller
{
    /**
     * Display the returning student application form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $strands = Strand::all();
        return view('returning', compact('strands'));
    }

    /**
     * Display the returning student application form. Alias for index().
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->index();
    }

    /**
     * Store a returning student application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'student_id' => 'required|string|max:20',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'Sex' => 'required|string|in:Male,Female',
            'DateOfBirth' => 'required|date',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:11',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'father_first_name' => 'nullable|string|max:100',
            'father_middle_name' => 'nullable|string|max:100',
            'father_last_name' => 'nullable|string|max:100',
            'father_contact_number' => 'nullable|string|max:11',
            'father_occupation' => 'nullable|string|max:100',
            'mother_first_name' => 'nullable|string|max:100',
            'mother_middle_name' => 'nullable|string|max:100',
            'mother_last_name' => 'nullable|string|max:100',
            'mother_contact_number' => 'nullable|string|max:11',
            'mother_occupation' => 'nullable|string|max:100',
            'guardian_first_name' => 'nullable|string|max:100',
            'guardian_last_name' => 'nullable|string|max:100',
            'guardian_relationship' => 'nullable|string|max:50',
            'guardian_contact_number' => 'nullable|string|max:11',
            'strand_id' => 'required|exists:strands,id',
            'year_level' => 'required|in:11,12',
            'academic_year' => 'required|string|max:9',
            'SubjectsTaken' => 'nullable|string',
            'grade_file_upload' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'declaration' => 'required|accepted',
        ]);

        try {
            // Check if student with the given ID exists
            $existingStudent = Student::where('student_id', $validatedData['student_id'])->first();
            
            if (!$existingStudent) {
                return redirect()->back()->withErrors(['student_id' => 'Student ID not found in our records. Please check your ID or apply as a new student.'])->withInput();
            }

            // Update student record
            $existingStudent->update([
                'firstname' => $validatedData['first_name'],
                'middlename' => $validatedData['middle_name'],
                'lastname' => $validatedData['last_name'],
                'Sex' => $validatedData['Sex'],
                'DateOfBirth' => $validatedData['DateOfBirth'],
                'email' => $validatedData['email'],
                'contactno' => $validatedData['contact_number'],
                'strand_id' => $validatedData['strand_id'],
                'year_level' => $validatedData['year_level'],
                'status' => 'Pending', // Set status as pending for admin approval
            ]);

            // Store or update student details
            $studentDetails = StudentDetail::updateOrCreate(
                ['student_id' => $existingStudent->id],
                [
                    'address_street' => $validatedData['street'],
                    'address_barangay' => $validatedData['barangay'],
                    'address_city' => $validatedData['city'],
                    'address_province' => $validatedData['province'],
                    'address_postal' => $validatedData['postal_code'],
                    'father_firstname' => $validatedData['father_first_name'],
                    'father_middlename' => $validatedData['father_middle_name'],
                    'father_lastname' => $validatedData['father_last_name'],
                    'father_contactno' => $validatedData['father_contact_number'],
                    'father_occupation' => $validatedData['father_occupation'],
                    'mother_firstname' => $validatedData['mother_first_name'],
                    'mother_middlename' => $validatedData['mother_middle_name'],
                    'mother_lastname' => $validatedData['mother_last_name'],
                    'mother_contactno' => $validatedData['mother_contact_number'],
                    'mother_occupation' => $validatedData['mother_occupation'],
                    'guardian_firstname' => $validatedData['guardian_first_name'],
                    'guardian_lastname' => $validatedData['guardian_last_name'],
                    'guardian_relationship' => $validatedData['guardian_relationship'],
                    'guardian_contactno' => $validatedData['guardian_contact_number'],
                    'subjects_taken' => $validatedData['SubjectsTaken'] ?? null,
                    'academic_year' => $validatedData['academic_year'],
                ]
            );

            // Handle file upload for grades report
            if ($request->hasFile('grade_file_upload')) {
                $file = $request->file('grade_file_upload');
                $fileName = 'grades_' . $existingStudent->student_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('student_documents', $fileName, 'public');
                
                // Update or create record for the attachment
                \DB::table('attachments')->updateOrInsert(
                    ['student_id' => $existingStudent->id, 'type' => 'grades'],
                    [
                        'filename' => $fileName,
                        'filepath' => $filePath,
                        'uploaded_at' => now(),
                    ]
                );
            }

            return redirect()->route('returning.index')->with('success', 'Your returning student application has been submitted successfully. Please wait for the approval of your application.');

        } catch (\Exception $e) {
            Log::error('Error in returning student application: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your application. Please try again later.'])->withInput();
        }
    }
}