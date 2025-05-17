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
                            </div>
                        </div>

                        <div class="card card-secondary mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Address Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="street_address">Street Address <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="street_address" name="street_address"
                                        value="{{ old('street_address') }}" required>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_name">Parent's Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="parent_name" name="parent_name"
                                                value="{{ old('parent_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardian_name">Guardian's Name</label>
                                            <input type="text" class="form-control" id="guardian_name"
                                                name="guardian_name" value="{{ old('guardian_name') }}">
                                            <small class="form-text text-muted">If different from parent</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="parent_guardian_contact">Parent/Guardian Contact Number <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="parent_guardian_contact"
                                        name="parent_guardian_contact" value="{{ old('parent_guardian_contact') }}"
                                        required pattern="[0-9]{11}">
                                    <small class="form-text text-muted">11-digit phone number (e.g.,
                                        09123456789)</small>
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
                                            <label for="grade_level">Grade Level <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="grade_level" name="grade_level" required>
                                                <option value="">Select Grade Level</option>
                                                <option value="11" {{ old('grade_level') == '11' ? 'selected' : '' }}>
                                                    Grade 11</option>
                                                <option value="12" {{ old('grade_level') == '12' ? 'selected' : '' }}>
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
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="program" name="program"
                                        value="{{ old('program') }}" required>
                                    <small class="form-text text-muted">e.g., STEM, ABM, HUMSS, etc.</small>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Required Documents</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="report_card_path">Report Card <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="report_card_path"
                                                name="report_card_path" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <label class="custom-file-label" for="report_card_path">Choose file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG (Max:
                                        2MB)</small>
                                </div>

                                <div class="form-group">
                                    <label for="good_moral_path">Good Moral Certificate <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="good_moral_path"
                                                name="good_moral_path" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <label class="custom-file-label" for="good_moral_path">Choose file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG (Max:
                                        2MB)</small>
                                </div>

                                <div class="form-group">
                                    <label for="birth_certificate_path">Birth Certificate <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="birth_certificate_path"
                                                name="birth_certificate_path" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <label class="custom-file-label" for="birth_certificate_path">Choose
                                                file</label>
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