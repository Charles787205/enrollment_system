<?php

namespace App\Http\Controllers;

use App\Models\Transferee;
use App\Models\Strand; // Added to fetch available strands
use App\Models\Student;
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
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|size:4',
            'parent_name' => 'required|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'parent_guardian_contact' => 'required|string|size:11',
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
    
        // Save the transferee application with the file paths
        $transferee = Transferee::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'street_address' => $request->street_address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'parent_name' => $request->parent_name,
            'guardian_name' => $request->guardian_name,
            'parent_guardian_contact' => $request->parent_guardian_contact,
            'previous_school' => $request->previous_school,
            'grade_level' => $request->grade_level,
            'strand_id' => $request->strand_id,
            'academic_year' => $request->academic_year,
            'report_card_path' => $reportCardPath,
            'good_moral_path' => $goodMoralPath,
            'birth_certificate_path' => $birthCertificatePath,
            'status' => 'pending'
        ]);
    
        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
    

    // public function accept($id)
    // {
    //     $transferee = Transferee::findOrFail($id);

    //     // Transfer to students table
    //     $student = new Student();
    //     $student->full_name = $transferee->full_name;
    //     $student->email = $transferee->email;
    //     $student->previous_school = $transferee->previous_school;
    //     $student->program = $transferee->program;
    //     $student->strand_id = $transferee->strand_id; // Added to save the strand_id to the student table
    //     $student->report_card_path = $transferee->report_card_path;
    //     $student->good_moral_path = $transferee->good_moral_path;
    //     $student->birth_certificate_path = $transferee->birth_certificate_path;
    //     $student->created_at = now();
    //     $student->updated_at = now();
    //     $student->save();

    //     // Delete from transferee table
    //     $transferee->delete();

    //     return redirect()->route('admin.transferees.index')->with('success', 'Transferee accepted and moved to students.');
    // }

    public function decline($id)
    {
        $transferee = Transferee::findOrFail($id);

        // Delete from transferee table
        $transferee->delete();

        return redirect()->route('admin.transferees.index')->with('success', 'Transferee declined and deleted.');
    }
}


