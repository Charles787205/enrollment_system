@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="header">
        <h1>Edit Enrollment</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.enrollment.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $enrollment->full_name) }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="grade_level">Grade Level</label>
                    <select class="form-control @error('grade_level') is-invalid @enderror" id="grade_level" name="grade_level" required>
                        <option value="">Select Grade Level</option>
                        <option value="Grade 11" {{ old('grade_level', $enrollment->grade_level) == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                        <option value="Grade 12" {{ old('grade_level', $enrollment->grade_level) == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                    </select>
                    @error('grade_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $enrollment->subject) }}">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="enrollment_date">Enrollment Date</label>
                    <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', $enrollment->enrollment_date ? $enrollment->enrollment_date->format('Y-m-d') : '') }}" required>
                    @error('enrollment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="Sex">Gender</label>
                    <select class="form-control @error('Sex') is-invalid @enderror" id="Sex" name="Sex" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('Sex', $enrollment->Sex) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('Sex', $enrollment->Sex) == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('Sex')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="DateOfBirth">Date of Birth</label>
                    <input type="date" class="form-control @error('DateOfBirth') is-invalid @enderror" id="DateOfBirth" name="DateOfBirth" value="{{ old('DateOfBirth', $enrollment->DateOfBirth ? $enrollment->DateOfBirth->format('Y-m-d') : '') }}" required>
                    @error('DateOfBirth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Enrollment</button>
                    <a href="{{ route('admin.enrollment.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection