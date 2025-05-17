<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Strand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StrandsController extends Controller
{
  public function getStrands()
{
    $strands = Strand::where('status', 'active')
        ->orderBy('name')
        ->get(['id', 'name', 'code']);
    return response()->json($strands);
}

    public function index(Request $request)
{
    $query = Strand::query();

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $strands = $query->get();

    return view('admin.strands.index', compact('strands'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:strands',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive'
        ]);

        Strand::create($validated);

        return redirect()->route('admin.strands.index')
            ->with('success', 'Strand created successfully.');
    }

    public function edit(Strand $strand)
    {
        return view('admin.strands.edit', compact('strand'));
    }


public function update(Request $request, Strand $strand)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'code' => [
            'required',
            'string',
            'max:50',
            Rule::unique('strands')->ignore($strand->id)
        ],
        'description' => 'required|string',
        'capacity' => 'required|integer|min:1',
        'status' => 'required|in:active,inactive'
    ]);

    try {
        $strand->update($validated);
        return redirect()->route('admin.strands.index')
            ->with('success', 'Strand updated successfully');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to update strand'])
            ->withInput();
    }
}

    public function destroy(Strand $strand)
    {
        if ($strand->students()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete strand with enrolled students.']);
        }

        $strand->delete();

        return redirect()->route('admin.strands.index')
            ->with('success', 'Strand deleted successfully.');
    }
}
