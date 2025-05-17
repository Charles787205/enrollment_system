@extends('layouts.app')

@section('content')
    <div class="main-content">
        <h1>Edit Faculty Member</h1>

        <form method="POST" action="{{ route('admin.faculty.update', $faculty->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $faculty->name }}" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-control" id="gender">
                    <option value="Male" {{ $faculty->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $faculty->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $faculty->gender == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $faculty->email }}" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" name="position" class="form-control" id="position" value="{{ $faculty->position }}" required>
            </div>

            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" id="contact_number" value="{{ $faculty->contact_number }}">
            </div>

            <button type="submit" class="btn btn-danger">Update</button>
        </form>
    </div>
@endsection
