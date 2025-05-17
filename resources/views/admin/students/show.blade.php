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
            <a href="{{ route('admin.students.index') }}" class="custom-link text-decoration-none">← Back to
                Students</a>
            <a href="javascript:void(0);" onclick="location.reload();" class="custom-link text-decoration-none">Refresh
                Page</a>
        </div>

        <!-- Title -->
        <h2 class="text-center text-danger mb-4">View Student</h2>

        <!-- Student Information -->
        @php
        $fields = [
        'First Name' => $student->first_name,
        'Middle Name' => $student->middle_name ?: 'N/A',
        'Last Name' => $student->last_name,
        'Date of Birth' => $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') :
        'N/A',
        'Sex' => $student->Sex,
        'Phone Number' => $student->PhoneNumber,
        'Email Address' => $student->email,
        'Address' => $student->Address,
        'Year Level' => $student->year_level,
        'Status' => $student->status,
        'Strand' => $student->strand_id ? $student->strand->name . ' (' . $student->strand->code . ')' : 'N/A',
        'Subjects Taken' => $student->SubjectsTaken,
        'Student ID' => $student->student_id,
        ];
        @endphp

        @foreach ($fields as $label => $value)
        <div class="form-group mb-3">
            <label class="form-label"><strong>{{ $label }}:</strong></label>
            <p class="form-control-plaintext">{{ $value }}</p>
        </div>
        @endforeach

        <!-- Clearance File Section -->
        <div class="form-group mb-3">
            <label class="form-label"><strong>Clearance from Previous Semester:</strong></label>
            @if ($student->grade_file_url)
            <!-- View Document Link -->
            <a href="#" class="btn custom-btn text-white" data-bs-toggle="modal" data-bs-target="#imageModal">View
                Document</a>
            @else
            <p class="form-control-plaintext">No attachment available</p>
            @endif
        </div>

        <!-- Modal for Image -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Clearance Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($student->grade_file_url)
                        @php
                        $extension = pathinfo($student->grade_file_url, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $student->grade_file_url) }}" alt="Clearance Document"
                            style="max-width: 100%; height: auto; border-radius: 8px;">
                        @elseif (strtolower($extension) == 'pdf')
                        <embed src="{{ asset('storage/' . $student->grade_file_url) }}" type="application/pdf"
                            width="100%" height="600px" />
                        @else
                        <p>Unsupported file type.</p>
                        @endif
                        @else
                        <p>No clearance document available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
@endsection