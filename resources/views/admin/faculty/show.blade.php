@extends('layouts.admin')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Custom Styles -->
<style>
    /* Custom color for hyperlinks */
    .custom-link {
        color: maroon;
        font-weight: bold;
    }
    .custom-link:hover {
        color: darkred;
        text-decoration: underline;
    }

    /* Custom color for button */
    .custom-btn {
        background-color: maroon;
        border-color: maroon;
    }
    .custom-btn:hover {
        background-color: darkred;
        border-color: darkred;
    }
</style>

<div class="container mt-4">
    <div class="card mx-auto" style="max-width: 600px; border: 1px solid #ddd; border-radius: 8px; padding: 2rem;">

        <!-- Back and Refresh Links -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.faculty.index') }}" class="custom-link text-decoration-none">← Back to Faculty List</a>
            <a href="javascript:void(0);" onclick="location.reload();" class="custom-link text-decoration-none">Refresh Page</a>
        </div>

        <!-- Title -->
        <h2 class="text-center text-danger mb-4">View Faculty Member</h2>

        <!-- Faculty Information -->
        @php
            $fields = [
                'Full Name' => $faculty->name,
                'Gender' => $faculty->gender ?? 'N/A',
                'Email Address' => $faculty->email,
                'Position' => $faculty->position,
                'Contact Number' => $faculty->contact_number ?? 'N/A',
                'Created At' => $faculty->created_at->format('F j, Y, g:i a'),
                'Updated At' => $faculty->updated_at->format('F j, Y, g:i a'),
            ];
        @endphp

        @foreach ($fields as $label => $value)
            <div class="form-group mb-3">
                <label class="form-label"><strong>{{ $label }}:</strong></label>
                <p class="form-control-plaintext">{{ $value }}</p>
            </div>
        @endforeach

        <!-- Actions (Edit/Delete Faculty) -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.faculty.edit', $faculty->id) }}" class="btn custom-btn text-white">Edit Faculty</a>
            <form action="{{ route('admin.faculty.destroy', $faculty->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Faculty</button>
            </form>
        </div>

    </div>
</div>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
@endsection
