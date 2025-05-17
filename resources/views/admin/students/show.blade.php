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

    .section-header {
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 5px;
        margin-top: 20px;
        margin-bottom: 15px;
        border-left: 4px solid maroon;
    }
</style>

<div class="container mt-4">
    <div class="card mx-auto" style="max-width: 800px; border: 1px solid #ddd; border-radius: 8px; padding: 2rem;">

        <!-- Back and Refresh Links -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.students.index') }}" class="custom-link text-decoration-none">← Back to
                Students</a>
            <a href="javascript:void(0);" onclick="location.reload();" class="custom-link text-decoration-none">Refresh
                Page</a>
        </div>

        <!-- Title -->
        <h2 class="text-center text-danger mb-4">Student Details</h2>

        <div class="d-flex justify-content-end mb-3">
            <span class="badge bg-{{ $student->type == 'old' ? 'primary' : 'success' }} p-2">
                {{ ucfirst($student->type) }} Student
            </span>
        </div>

        <!-- Personal Information -->
        <h4 class="section-header">Personal Information</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Student ID:</strong></label>
                    <p class="form-control-plaintext">{{ $student->student_id }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Full Name:</strong></label>
                    <p class="form-control-plaintext">{{ $student->first_name }} {{ $student->middle_name }}
                        {{ $student->last_name }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Gender:</strong></label>
                    <p class="form-control-plaintext">{{ $student->Sex }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Date of Birth:</strong></label>
                    <p class="form-control-plaintext">
                        {{ $student->DateOfBirth ? \Carbon\Carbon::parse($student->DateOfBirth)->format('F d, Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Email Address:</strong></label>
                    <p class="form-control-plaintext">{{ $student->email }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Contact Number:</strong></label>
                    <p class="form-control-plaintext">{{ $student->contact_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <h4 class="section-header">Address Information</h4>
        @if($student->details)
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Street Address:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->street }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Barangay:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->barangay }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>City/Municipality:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->city }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Province:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->province }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Postal Code:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->postal_code }}</p>
                </div>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <h4 class="section-header">Parent/Guardian Information</h4>

        <!-- Father Information -->
        @if($student->details->father_first_name || $student->details->father_last_name)
        <h5 class="mt-3 mb-2">Father's Information</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Father's Name:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->father_full_name }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Contact Number:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->father_contact_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Occupation:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->father_occupation ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Mother Information -->
        @if($student->details->mother_first_name || $student->details->mother_last_name)
        <h5 class="mt-3 mb-2">Mother's Information</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Mother's Name:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->mother_full_name }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Contact Number:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->mother_contact_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Occupation:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->mother_occupation ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Guardian Information -->
        @if($student->details->guardian_first_name || $student->details->guardian_last_name)
        <h5 class="mt-3 mb-2">Guardian's Information</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Guardian's Name:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->guardian_full_name }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Contact Number:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->guardian_contact_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Relationship:</strong></label>
                    <p class="form-control-plaintext">{{ $student->details->guardian_relationship ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif
        @else
        <p>No detailed address or parent/guardian information available.</p>
        @endif

        <!-- Academic Information -->
        <h4 class="section-header">Academic Information</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Year Level:</strong></label>
                    <p class="form-control-plaintext">Grade {{ $student->year_level }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Status:</strong></label>
                    <p class="form-control-plaintext">{{ $student->status }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Strand:</strong></label>
                    <p class="form-control-plaintext">
                        {{ $student->strand ? $student->strand->name . ' (' . $student->strand->code . ')' : 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Previous School:</strong></label>
                    <p class="form-control-plaintext">{{ $student->previous_school ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <h4 class="section-header">Student Documents</h4>

        <!-- Clearance File Section -->
        <div class="form-group mb-3">
            <label class="form-label"><strong>Clearance/Grade Report:</strong></label>
            @if ($student->grade_file_url)
            <!-- View Document Link -->
            <a href="#" class="btn custom-btn text-white" data-bs-toggle="modal" data-bs-target="#gradeFileModal">View
                Document</a>
            @else
            <p class="form-control-plaintext">No clearance/grade report available</p>
            @endif
        </div>

        <!-- Transferee Documents (if type is transferee) -->
        @if($student->type == 'transferee')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Report Card:</strong></label>
                    @if ($student->report_card_path)
                    <a href="#" class="btn custom-btn text-white" data-bs-toggle="modal"
                        data-bs-target="#reportCardModal">View
                        Document</a>
                    @else
                    <p class="form-control-plaintext">Not available</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Good Moral Certificate:</strong></label>
                    @if ($student->good_moral_path)
                    <a href="#" class="btn custom-btn text-white" data-bs-toggle="modal"
                        data-bs-target="#goodMoralModal">View
                        Document</a>
                    @else
                    <p class="form-control-plaintext">Not available</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Birth Certificate:</strong></label>
                    @if ($student->birth_certificate_path)
                    <a href="#" class="btn custom-btn text-white" data-bs-toggle="modal"
                        data-bs-target="#birthCertModal">View
                        Document</a>
                    @else
                    <p class="form-control-plaintext">Not available</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn custom-btn text-white">Edit Student
                Information</a>
            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this student?')">
                    Delete Student
                </button>
            </form>
        </div>

        <!-- Modals for Documents -->
        <div class="modal fade" id="gradeFileModal" tabindex="-1" aria-labelledby="gradeFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="gradeFileModalLabel">Clearance/Grade Document</h5>
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
                        <p>No document available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Card Modal -->
        <div class="modal fade" id="reportCardModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Report Card</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($student->report_card_path)
                        @php
                        $extension = pathinfo($student->report_card_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $student->report_card_path) }}" alt="Report Card"
                            style="max-width: 100%; height: auto; border-radius: 8px;">
                        @elseif (strtolower($extension) == 'pdf')
                        <embed src="{{ asset('storage/' . $student->report_card_path) }}" type="application/pdf"
                            width="100%" height="600px" />
                        @else
                        <p>Unsupported file type.</p>
                        @endif
                        @else
                        <p>No document available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Good Moral Modal -->
        <div class="modal fade" id="goodMoralModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Good Moral Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($student->good_moral_path)
                        @php
                        $extension = pathinfo($student->good_moral_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $student->good_moral_path) }}" alt="Good Moral Certificate"
                            style="max-width: 100%; height: auto; border-radius: 8px;">
                        @elseif (strtolower($extension) == 'pdf')
                        <embed src="{{ asset('storage/' . $student->good_moral_path) }}" type="application/pdf"
                            width="100%" height="600px" />
                        @else
                        <p>Unsupported file type.</p>
                        @endif
                        @else
                        <p>No document available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Birth Certificate Modal -->
        <div class="modal fade" id="birthCertModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Birth Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($student->birth_certificate_path)
                        @php
                        $extension = pathinfo($student->birth_certificate_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $student->birth_certificate_path) }}" alt="Birth Certificate"
                            style="max-width: 100%; height: auto; border-radius: 8px;">
                        @elseif (strtolower($extension) == 'pdf')
                        <embed src="{{ asset('storage/' . $student->birth_certificate_path) }}" type="application/pdf"
                            width="100%" height="600px" />
                        @else
                        <p>Unsupported file type.</p>
                        @endif
                        @else
                        <p>No document available.</p>
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