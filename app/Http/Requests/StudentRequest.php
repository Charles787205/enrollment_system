<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|unique:students,student_id|max:255',
            'full_name' => 'required|max:255',
            'year_level' => 'required|integer|in:11,12',
            'email' => 'required|email|unique:students,email',
            'status' => 'required|in:PASSED,FAILED',
            'strand' => 'required|in:STEM,ABM,HUMSS,TVL,GAS',
            'student_id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'grade_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}