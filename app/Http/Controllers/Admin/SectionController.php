<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Strand;


class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all(); // No need for ->with('strand') now
        $strands = Strand::all();
        return view('admin.section.index', compact('sections', 'strands'));
    }
    

    public function create()
    {
        $strands = Strand::all();
        return view('admin.section.create', compact('strands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'strand_id' => 'required|exists:strands,id',
            'capacity' => 'required|integer|min:1',
        ]);

        Section::create([
            'name' => $request->name,
            'strand_id' => $request->strand_id,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.section.index')->with('success', 'Section created successfully.');
    }

    public function show($id)
    {
        $section = Section::findOrFail($id);
        return view('admin.section.show', compact('section'));
    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);
        $strands = Strand::all();
        return view('admin.section.edit', compact('section', 'strands'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'strand_id' => 'required|exists:strands,id',
            'capacity' => 'required|integer|min:1',
        ]);

        $section = Section::findOrFail($id);
        $section->update([
            'name' => $request->name,
            'strand_id' => $request->strand_id,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.section.index')->with('success', 'Section updated successfully.');
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.section.index')->with('success', 'Section deleted successfully.');
    }
}