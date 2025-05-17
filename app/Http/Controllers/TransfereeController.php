<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\Strand;
use Illuminate\Http\Request;

class TransfereeController extends Controller
{
    public function index()
    {
        $strands = Strand::all();
        return view('transferee', compact('strands'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_number' => 'required|string|size:11',
            'Sex' => 'required|string|in:Male,Female',
            'DateOfBirth' => 'required|date',
            'street_address' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|size:4',
            'father_first_name' => 'required|string|max:255',
            'father_middle_name' => 'nullable|string|max:255',
            'father_last_name' => 'required|string|max:255',
            'father_contact_number' => 'required|string|size:11',
            'father_occupation' => 'required|string|max:255',
            'mother_first_name' => 'required|string|max:255',
            'mother_middle_name' => 'nullable|string|max:255',
            'mother_last_name' => 'required|string|max:255',
            'mother_contact_number' => 'required|string|size:11',
            'mother_occupation' => 'required|string|max:255',
            'guardian_first_name' => 'nullable|string|max:255',
            'guardian_middle_name' => 'nullable|string|max:255',
            'guardian_last_name' => 'nullable|string|max:255',
            'guardian_contact_number' => 'nullable|string|size:11',
            'guardian_relationship' => 'nullable|string|max:255',
            'previous_school' => 'required|string',
            'grade_level' => 'required|string',
            'strand_id' => 'required|exists:strands,id',
            'academic_year' => 'required|string',
            'report_card_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'good_moral_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'birth_certificate_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file uploads and store them in the 'public' storage disk under 'documents' folder
        $reportCardPath = $request->file('report_card_path')->store('documents', 'public');
        $goodMoralPath = $request->file('good_moral_path')->store('documents', 'public');
        $birthCertificatePath = $request->file('birth_certificate_path')->store('documents', 'public');

        // Create student with type='transferee'
        $student = Student::create([
            'type' => 'transferee',
            'student_id' => 'T' . date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'year_level' => $request->grade_level,
            'strand_id' => $request->strand_id,
            'status' => 'PENDING',
            'previous_school' => $request->previous_school,
            'report_card_path' => $reportCardPath,
            'good_moral_path' => $goodMoralPath,
            'birth_certificate_path' => $birthCertificatePath,
        ]);
        
        // Create student details record with address and parent information
        StudentDetail::create([
            'student_id' => $student->id,
            'street' => $request->street_address,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'gender' => $request->Sex,
            'date_of_birth' => $request->DateOfBirth,
            'father_first_name' => $request->father_first_name,
            'father_middle_name' => $request->father_middle_name,
            'father_last_name' => $request->father_last_name,
            'father_contact_number' => $request->father_contact_number,
            'father_occupation' => $request->father_occupation,
            'mother_first_name' => $request->mother_first_name,
            'mother_middle_name' => $request->mother_middle_name,
            'mother_last_name' => $request->mother_last_name,
            'mother_contact_number' => $request->mother_contact_number,
            'mother_occupation' => $request->mother_occupation,
            'guardian_first_name' => $request->guardian_first_name,
            'guardian_middle_name' => $request->guardian_middle_name,
            'guardian_last_name' => $request->guardian_last_name,
            'guardian_contact_number' => $request->guardian_contact_number,
            'guardian_relationship' => $request->guardian_relationship,
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
    
    public function decline($id)
    {
        $student = Student::where('type', 'transferee')->findOrFail($id);
        
        // Delete related student details
        if ($student->details) {
            $student->details->delete();
        }
        
        // Delete student record
        $student->delete();

        return redirect()->route('admin.transferees.index')->with('success', 'Transferee declined and deleted.');
    }
}


