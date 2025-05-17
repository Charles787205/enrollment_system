<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty; 

class FacultyController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    $faculty = Faculty::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('position', 'like', "%{$search}%");
    })->paginate(10);

    return view('admin.faculty.index', compact('faculty', 'search'));
}


    public function create()
    {
        return view('admin.faculty.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string',
            'email' => 'required|email',
            'position' => 'required|string',
            'contact_number' => 'nullable|string',
        ]);
    
        Faculty::create($request->all());
    
        return redirect()->route('admin.faculty.index')->with('success', 'Faculty added successfully!');
    }
    public function show($id)
    {
        return "Show faculty with ID: $id";
    }

    public function edit($id)
    {
        return "Edit faculty with ID: $id";
    }

    public function update(Request $request, Faculty $faculty)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'email' => 'required|email|unique:faculties,email,' . $faculty->id,
            'position' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
        ]);
    
        // Update the faculty member's data
        $faculty->update($validatedData);
    
        // Redirect with success message
        return redirect()->route('admin.faculty.index')->with('success', 'Faculty member updated successfully!');
    }
    
    
    
public function destroy($id)
{
    Faculty::destroy($id);
    return redirect()->route('admin.faculty.index')->with('success', 'Faculty deleted successfully!');
}

    
}