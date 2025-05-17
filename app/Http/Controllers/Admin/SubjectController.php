<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    // Display all subjects with search functionality
    public function index(Request $request)
    {
        $subjects = Subject::when($request->search, function ($query) use ($request) {
            return $query->where('title', 'like', '%' . $request->search . '%')
                         ->orWhere('code', 'like', '%' . $request->search . '%'); // Add search on code as well
        })->paginate(10); // Added pagination for better performance

        return view('admin.subjects.index', compact('subjects'));
    }


public function store(Request $request)
{
    try {
        // Log the incoming request data for debugging
        \Log::info('Subject creation attempt:', $request->all());
        
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:subjects',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'grade_level' => 'required|string|in:Grade 11,Grade 12',
        ]);

        // Format the grade_level to match database expectations (remove "Grade " prefix)
        $validated['grade_level'] = str_replace('Grade ', '', $validated['grade_level']);
        
        // Add default values for the required fields not in the form
        $validated['strand_id'] = $request->strand_id ?? null; // Make strand_id nullable
        $validated['units'] = $request->units ?? 3; // Default units
        $validated['hours_per_week'] = $request->hours_per_week ?? 3; // Default hours per week

        \Log::info('Processed data for creation:', $validated);
        
        $subject = Subject::create($validated);
        
        \Log::info('Subject created:', ['id' => $subject->id]);

        // For AJAX requests, return JSON response
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject added successfully');
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed:', ['errors' => $e->errors()]);
        
        // For AJAX requests, return validation errors as JSON
        if ($request->ajax()) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        return back()->withInput()->withErrors($e->errors());
    } catch (\Exception $e) {
        \Log::error('Subject creation failed:', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        
        if ($request->ajax()) {
            return response()->json(['error' => 'Failed to add subject: ' . $e->getMessage()], 500);
        }
        
        return back()->withInput()->withErrors(['error' => 'Failed to add subject: ' . $e->getMessage()]);
    }
}

    // Show a specific subject
    public function show($id)
    {
        // Find the subject by its ID
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.show', compact('subject'));
    }


    // Delete a subject
    public function destroy($id)
    {
        // Delete the subject by its ID
        Subject::destroy($id);

        // Redirect to subjects index with success message
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully!');
    }

public function edit($id)
{
    $subject = Subject::findOrFail($id);
    return response()->json($subject);
}

public function update(Request $request, $id)
{
    try {
        $subject = Subject::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:subjects,code,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'grade_level' => 'required|string|in:Grade 11,Grade 12'
        ]);
        
        // Format the grade_level to match database expectations (remove "Grade " prefix)
        $validated['grade_level'] = str_replace('Grade ', '', $validated['grade_level']);

        // Preserve the existing values or use provided ones for the fields not in the form
        $validated['strand_id'] = $request->strand_id ?? $subject->strand_id;
        $validated['units'] = $request->units ?? $subject->units;
        $validated['hours_per_week'] = $request->hours_per_week ?? $subject->hours_per_week;

        \Log::info('Updating subject:', $validated);
        
        $subject->update($validated);
        
        \Log::info('Subject updated successfully:', ['id' => $subject->id]);

        // For AJAX requests, return JSON response
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully');
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed during update:', ['errors' => $e->errors()]);
        
        // For AJAX requests, return validation errors as JSON
        if ($request->ajax()) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        return back()->withInput()->withErrors($e->errors());
    } catch (\Exception $e) {
        \Log::error('Subject update failed:', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        
        if ($request->ajax()) {
            return response()->json(['error' => 'Failed to update subject: ' . $e->getMessage()], 500);
        }
        
        return back()->withInput()->withErrors(['error' => 'Failed to update subject: ' . $e->getMessage()]);
    }
}
}