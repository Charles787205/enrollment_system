@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Old Student</h3>
                </div>

                <form method="POST" action="{{ route('admin.old_students.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Hidden field for student type -->
                        <input type="hidden" name="type" value="old">

                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Personal Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="first_name">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                value="{{ old('first_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="middle_name">Middle Name</label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                                value="{{ old('middle_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_number">Contact Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="contact_number"
                                                name="contact_number" value="{{ old('contact_number') }}" required
                                                pattern="[0-9]{11}">
                                            <small class="form-text text-muted">11-digit phone number (e.g.,
                                                09123456789)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Sex">Gender <span class="text-danger">*</span></label>
                                            <select class="form-control" id="Sex" name="Sex" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ old('Sex') == 'Male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="Female" {{ old('Sex') == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="DateOfBirth">Date of Birth</label>
                                            <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth"
                                                value="{{ old('DateOfBirth') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Address Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="street">Street Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="street" name="street"
                                        value="{{ old('street') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="barangay">Barangay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="barangay" name="barangay"
                                        value="{{ old('barangay') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">City/Municipality <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ old('city') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="province">Province <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="province" name="province"
                                                value="{{ old('province') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="postal_code">Postal Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                                value="{{ old('postal_code') }}" required pattern="[0-9]{4}">
                                            <small class="form-text text-muted">4-digit code (e.g., 1234)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Parent/Guardian Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="father_first_name">Father's First Name</label>
                                            <input type="text" class="form-control" id="father_first_name"
                                                name="father_first_name" value="{{ old('father_first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="father_middle_name">Father's Middle Name</label>
                                            <input type="text" class="form-control" id="father_middle_name"
                                                name="father_middle_name" value="{{ old('father_middle_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="father_last_name">Father's Last Name</label>
                                            <input type="text" class="form-control" id="father_last_name"
                                                name="father_last_name" value="{{ old('father_last_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="father_contact_number">Father's Contact Number</label>
                                            <input type="tel" class="form-control" id="father_contact_number"
                                                name="father_contact_number" value="{{ old('father_contact_number') }}"
                                                pattern="[0-9]{11}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="father_occupation">Father's Occupation</label>
                                            <input type="text" class="form-control" id="father_occupation"
                                                name="father_occupation" value="{{ old('father_occupation') }}">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mother_first_name">Mother's First Name</label>
                                            <input type="text" class="form-control" id="mother_first_name"
                                                name="mother_first_name" value="{{ old('mother_first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mother_middle_name">Mother's Middle Name</label>
                                            <input type="text" class="form-control" id="mother_middle_name"
                                                name="mother_middle_name" value="{{ old('mother_middle_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mother_last_name">Mother's Last Name</label>
                                            <input type="text" class="form-control" id="mother_last_name"
                                                name="mother_last_name" value="{{ old('mother_last_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mother_contact_number">Mother's Contact Number</label>
                                            <input type="tel" class="form-control" id="mother_contact_number"
                                                name="mother_contact_number" value="{{ old('mother_contact_number') }}"
                                                pattern="[0-9]{11}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mother_occupation">Mother's Occupation</label>
                                            <input type="text" class="form-control" id="mother_occupation"
                                                name="mother_occupation" value="{{ old('mother_occupation') }}">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardian_first_name">Guardian's First Name</label>
                                            <input type="text" class="form-control" id="guardian_first_name"
                                                name="guardian_first_name" value="{{ old('guardian_first_name') }}">
                                            <small class="form-text text-muted">If different from parents</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardian_last_name">Guardian's Last Name</label>
                                            <input type="text" class="form-control" id="guardian_last_name"
                                                name="guardian_last_name" value="{{ old('guardian_last_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardian_contact_number">Guardian Contact Number</label>
                                            <input type="tel" class="form-control" id="guardian_contact_number"
                                                name="guardian_contact_number"
                                                value="{{ old('guardian_contact_number') }}" pattern="[0-9]{11}">
                                            <small class="form-text text-muted">11-digit phone number (e.g.,
                                                09123456789)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardian_relationship">Relationship to Student</label>
                                            <input type="text" class="form-control" id="guardian_relationship"
                                                name="guardian_relationship" value="{{ old('guardian_relationship') }}">
                                            <small class="form-text text-muted">e.g., Aunt, Uncle, Grandparent</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Educational Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="previous_school">Previous School <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="previous_school" name="previous_school"
                                        value="{{ old('previous_school') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="strand_id">Strand <span class="text-danger">*</span></label>
                                            <select class="form-control" id="strand_id" name="strand_id" required>
                                                <option value="">Select Strand</option>
                                                @foreach($strands as $strand)
                                                <option value="{{ $strand->id }}"
                                                    {{ old('strand_id') == $strand->id ? 'selected' : '' }}>
                                                    {{ $strand->name }} ({{ $strand->code }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="year_level">Grade Level <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="year_level" name="year_level" required>
                                                <option value="">Select Grade Level</option>
                                                <option value="11" {{ old('year_level') == '11' ? 'selected' : '' }}>
                                                    Grade 11</option>
                                                <option value="12" {{ old('year_level') == '12' ? 'selected' : '' }}>
                                                    Grade 12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="academic_year">Academic Year <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="academic_year"
                                                name="academic_year"
                                                value="{{ old('academic_year') ?? date('Y').'-'.(date('Y')+1) }}"
                                                required>
                                            <small class="form-text text-muted">Format: YYYY-YYYY (e.g.,
                                                2024-2025)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="PENDING" {{ old('status') == 'PENDING' ? 'selected' : '' }}>
                                            PENDING</option>
                                        <option value="ENROLLED" {{ old('status') == 'ENROLLED' ? 'selected' : '' }}>
                                            ENROLLED</option>
                                        <option value="PASSED" {{ old('status') == 'PASSED' ? 'selected' : '' }}>PASSED
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Required Documents</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="grade_file_url">Grade Report or Clearance <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="grade_file_url"
                                                name="grade_file_url" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <label class="custom-file-label" for="grade_file_url">Choose file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG (Max:
                                        2MB)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.old_students.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Initialize custom file input
        bsCustomFileInput.init();

        // File size validation
        $('input[type="file"]').change(function () {
            var fileSize = this.files[0].size;
            var maxSize = 2 * 1024 * 1024; // 2MB

            if (fileSize > maxSize) {
                alert('File size must be less than 2MB');
                this.value = '';
                $(this).next('.custom-file-label').html('Choose file');
            }
        });
    });
</script>
@endsection