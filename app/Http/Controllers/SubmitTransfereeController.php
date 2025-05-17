<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transferee;

class TransfereeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'previous_school' => 'required|string|max:255',
            'program' => 'required|string|in:STEM,HUMSS,ABM,TVL',
            'academic_year' => 'required|string|in:2025-2026,2026-2027',
            'grade_level' => 'required|string|in:11,12',
            'additional_info' => 'nullable|string'
        ]);

        Transferee::create($validated);

        return redirect('/')->with('success', 'Your application has been submitted successfully!');
    }
}