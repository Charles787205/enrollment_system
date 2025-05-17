<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Returning Student Registration Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .form-container {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-header h2 {
      color: #3498db;
      font-weight: bold;
    }

    .form-section {
      margin-bottom: 30px;
      padding: 20px;
      border: 1px solid #eee;
      border-radius: 8px;
    }

    .form-section-title {
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #3498db;
    }

    .btn-submit {
      background-color: #3498db;
      border: none;
      padding: 12px 30px;
      font-weight: bold;
    }

    .btn-submit:hover {
      background-color: #2980b9;
    }

    .alert {
      border-radius: 8px;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class="container form-container">
    <div class="form-header">
      <div class="row align-items-center">
        <div class="col-md-2">
          <img src="{{ asset('img/logo.png') }}" alt="School Logo" class="img-fluid" style="max-height: 100px;">
        </div>
        <div class="col-md-8">
          <h2>Returning Student Registration Form</h2>
          <p class="text-muted">School Year {{ date('Y') }}-{{ date('Y') + 1 }}</p>
        </div>
      </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('returning.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-section">
        <h4 class="form-section-title">Student Information</h4>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="student_id" class="form-label">Student ID Number <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}"
              required>
            <small class="text-muted">Please enter your existing student ID number</small>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}"
              required>
          </div>
          <div class="col-md-4">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name"
              value="{{ old('middle_name') }}">
          </div>
          <div class="col-md-4">
            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}"
              required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="Sex" class="form-label">Sex <span class="text-danger">*</span></label>
            <select class="form-select" id="Sex" name="Sex" required>
              <option value="">Select...</option>
              <option value="Male" {{ old('Sex') == 'Male' ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ old('Sex') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="DateOfBirth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth" value="{{ old('DateOfBirth') }}"
              required>
          </div>
          <div class="col-md-4">
            <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="contact_number" name="contact_number"
              value="{{ old('contact_number') }}" required placeholder="09XXXXXXXXX" maxlength="11">
          </div>
        </div>
      </div>

      <div class="form-section">
        <h4 class="form-section-title">Address Information</h4>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="street" class="form-label">Street Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}" required>
          </div>
          <div class="col-md-6">
            <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="barangay" name="barangay" value="{{ old('barangay') }}"
              required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="city" class="form-label">City/Municipality <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
          </div>
          <div class="col-md-4">
            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}"
              required>
          </div>
          <div class="col-md-4">
            <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
              required maxlength="4">
          </div>
        </div>
      </div>

      <div class="form-section">
        <h4 class="form-section-title">Parent/Guardian Information</h4>

        <div class="mb-4">
          <h5>Father's Information</h5>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="father_first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="father_first_name" name="father_first_name"
                value="{{ old('father_first_name') }}">
            </div>
            <div class="col-md-4">
              <label for="father_middle_name" class="form-label">Middle Name</label>
              <input type="text" class="form-control" id="father_middle_name" name="father_middle_name"
                value="{{ old('father_middle_name') }}">
            </div>
            <div class="col-md-4">
              <label for="father_last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="father_last_name" name="father_last_name"
                value="{{ old('father_last_name') }}">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="father_contact_number" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="father_contact_number" name="father_contact_number"
                value="{{ old('father_contact_number') }}" placeholder="09XXXXXXXXX" maxlength="11">
            </div>
            <div class="col-md-6">
              <label for="father_occupation" class="form-label">Occupation</label>
              <input type="text" class="form-control" id="father_occupation" name="father_occupation"
                value="{{ old('father_occupation') }}">
            </div>
          </div>
        </div>

        <div class="mb-4">
          <h5>Mother's Information</h5>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="mother_first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="mother_first_name" name="mother_first_name"
                value="{{ old('mother_first_name') }}">
            </div>
            <div class="col-md-4">
              <label for="mother_middle_name" class="form-label">Middle Name</label>
              <input type="text" class="form-control" id="mother_middle_name" name="mother_middle_name"
                value="{{ old('mother_middle_name') }}">
            </div>
            <div class="col-md-4">
              <label for="mother_last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="mother_last_name" name="mother_last_name"
                value="{{ old('mother_last_name') }}">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="mother_contact_number" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="mother_contact_number" name="mother_contact_number"
                value="{{ old('mother_contact_number') }}" placeholder="09XXXXXXXXX" maxlength="11">
            </div>
            <div class="col-md-6">
              <label for="mother_occupation" class="form-label">Occupation</label>
              <input type="text" class="form-control" id="mother_occupation" name="mother_occupation"
                value="{{ old('mother_occupation') }}">
            </div>
          </div>
        </div>

        <div class="mb-4">
          <h5>Guardian's Information (if different from parents)</h5>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="guardian_first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name"
                value="{{ old('guardian_first_name') }}">
            </div>
            <div class="col-md-4">
              <label for="guardian_last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name"
                value="{{ old('guardian_last_name') }}">
            </div>
            <div class="col-md-4">
              <label for="guardian_relationship" class="form-label">Relationship to Student</label>
              <input type="text" class="form-control" id="guardian_relationship" name="guardian_relationship"
                value="{{ old('guardian_relationship') }}">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="guardian_contact_number" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="guardian_contact_number" name="guardian_contact_number"
                value="{{ old('guardian_contact_number') }}" placeholder="09XXXXXXXXX" maxlength="11">
            </div>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h4 class="form-section-title">Academic Information</h4>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="strand_id" class="form-label">Strand <span class="text-danger">*</span></label>
            <select class="form-select" id="strand_id" name="strand_id" required>
              <option value="">Select a strand...</option>
              @foreach($strands as $strand)
              <option value="{{ $strand->id }}" {{ old('strand_id') == $strand->id ? 'selected' : '' }}>
                {{ $strand->name }} ({{ $strand->code }})
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label for="year_level" class="form-label">Year Level <span class="text-danger">*</span></label>
            <select class="form-select" id="year_level" name="year_level" required>
              <option value="">Select...</option>
              <option value="11" {{ old('year_level') == '11' ? 'selected' : '' }}>Grade 11</option>
              <option value="12" {{ old('year_level') == '12' ? 'selected' : '' }}>Grade 12</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="academic_year" class="form-label">Academic Year <span class="text-danger">*</span></label>
            <select class="form-select" id="academic_year" name="academic_year" required>
              <option value="">Select...</option>
              <option value="{{ date('Y') }}-{{ date('Y') + 1 }}" selected>{{ date('Y') }}-{{ date('Y') + 1 }}
              </option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="SubjectsTaken" class="form-label">Previous Subjects Taken</label>
            <textarea class="form-control" id="SubjectsTaken" name="SubjectsTaken" rows="3">{{ old('SubjectsTaken')
                            }}</textarea>
            <small class="text-muted">List down subjects you've completed in your previous year (optional)
            </small>
          </div>
        </div>

        <div class="mb-3">
          <label for="grade_file_upload" class="form-label">Upload Latest Grade Report/Clearance <span
              class="text-danger">*</span></label>
          <input class="form-control" type="file" id="grade_file_upload" name="grade_file_upload" required>
          <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG (max 2MB)</small>
        </div>
      </div>

      <div class="form-section">
        <h4 class="form-section-title">Declaration</h4>
        <div class="mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="declaration" name="declaration" required>
            <label class="form-check-label" for="declaration">
              I hereby certify that the information provided above is true and correct to the best of my
              knowledge.
              I understand that any false information may result in the rejection of my application or
              subsequent termination from the school.
            </label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-submit">Submit Application</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>