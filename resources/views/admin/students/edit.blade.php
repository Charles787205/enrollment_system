<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #d32f2f;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            height: 2.5rem;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 4px rgba(211, 47, 47, 0.5);
        }

        button {
            background-color: #d32f2f;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(243, 96, 96);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #d32f2f;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .section-header {
            color: #d32f2f;
            border-bottom: 2px solid #d32f2f;
            padding-bottom: 0.5rem;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
        }

        .badge-primary {
            background-color: #0d6efd;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Student</h1>

        <div style="text-align: right; margin-bottom: 1rem;">
            <span class="badge {{ $student->type == 'old' ? 'badge-primary' : 'badge-success' }}">
                {{ ucfirst($student->type) }} Student
            </span>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger"
            style="background: #fee; color: #d32f2f; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hidden field to maintain the student type -->
            <input type="hidden" name="type" value="{{ $student->type }}">

            <h3 class="section-header">Personal Information</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id"
                        value="{{ old('student_id', $student->student_id) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name"
                        value="{{ old('first_name', $student->first_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name"
                        value="{{ old('middle_name', $student->middle_name) }}">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name"
                        value="{{ old('last_name', $student->last_name) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number"
                        value="{{ old('contact_number', $student->contact_number) }}" pattern="[0-9]{11}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="DateOfBirth">Date of Birth:</label>
                    <input type="date" id="DateOfBirth" name="DateOfBirth"
                        value="{{ old('DateOfBirth', $student->DateOfBirth) }}">
                </div>

                <div class="form-group">
                    <label for="Sex">Gender:</label>
                    <select id="Sex" name="Sex" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('Sex', $student->Sex) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('Sex', $student->Sex) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                </div>
            </div>

            <h3 class="section-header">Address Information</h3>

            <div class="form-group">
                <label for="street">Street Address:</label>
                <input type="text" id="street" name="street"
                    value="{{ old('street', $student->details->street ?? '') }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="barangay">Barangay:</label>
                    <input type="text" id="barangay" name="barangay"
                        value="{{ old('barangay', $student->details->barangay ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="city">City/Municipality:</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $student->details->city ?? '') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="province">Province:</label>
                    <input type="text" id="province" name="province"
                        value="{{ old('province', $student->details->province ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="postal_code">Postal Code:</label>
                    <input type="text" id="postal_code" name="postal_code"
                        value="{{ old('postal_code', $student->details->postal_code ?? '') }}" pattern="[0-9]{4}">
                </div>
            </div>

            <h3 class="section-header">Parent/Guardian Information</h3>

            <!-- Father's Information -->
            <h4 style="margin-bottom: 0.5rem;">Father's Information</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="father_first_name">First Name:</label>
                    <input type="text" id="father_first_name" name="father_first_name"
                        value="{{ old('father_first_name', $student->details->father_first_name ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="father_middle_name">Middle Name:</label>
                    <input type="text" id="father_middle_name" name="father_middle_name"
                        value="{{ old('father_middle_name', $student->details->father_middle_name ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="father_last_name">Last Name:</label>
                    <input type="text" id="father_last_name" name="father_last_name"
                        value="{{ old('father_last_name', $student->details->father_last_name ?? '') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="father_contact_number">Contact Number:</label>
                    <input type="text" id="father_contact_number" name="father_contact_number"
                        value="{{ old('father_contact_number', $student->details->father_contact_number ?? '') }}"
                        pattern="[0-9]{11}">
                </div>

                <div class="form-group">
                    <label for="father_occupation">Occupation:</label>
                    <input type="text" id="father_occupation" name="father_occupation"
                        value="{{ old('father_occupation', $student->details->father_occupation ?? '') }}">
                </div>
            </div>

            <!-- Mother's Information -->
            <h4 style="margin-top: 1rem; margin-bottom: 0.5rem;">Mother's Information</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="mother_first_name">First Name:</label>
                    <input type="text" id="mother_first_name" name="mother_first_name"
                        value="{{ old('mother_first_name', $student->details->mother_first_name ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="mother_middle_name">Middle Name:</label>
                    <input type="text" id="mother_middle_name" name="mother_middle_name"
                        value="{{ old('mother_middle_name', $student->details->mother_middle_name ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="mother_last_name">Last Name:</label>
                    <input type="text" id="mother_last_name" name="mother_last_name"
                        value="{{ old('mother_last_name', $student->details->mother_last_name ?? '') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="mother_contact_number">Contact Number:</label>
                    <input type="text" id="mother_contact_number" name="mother_contact_number"
                        value="{{ old('mother_contact_number', $student->details->mother_contact_number ?? '') }}"
                        pattern="[0-9]{11}">
                </div>

                <div class="form-group">
                    <label for="mother_occupation">Occupation:</label>
                    <input type="text" id="mother_occupation" name="mother_occupation"
                        value="{{ old('mother_occupation', $student->details->mother_occupation ?? '') }}">
                </div>
            </div>

            <!-- Guardian's Information -->
            <h4 style="margin-top: 1rem; margin-bottom: 0.5rem;">Guardian's Information (if different from parents)</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="guardian_first_name">First Name:</label>
                    <input type="text" id="guardian_first_name" name="guardian_first_name"
                        value="{{ old('guardian_first_name', $student->details->guardian_first_name ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="guardian_last_name">Last Name:</label>
                    <input type="text" id="guardian_last_name" name="guardian_last_name"
                        value="{{ old('guardian_last_name', $student->details->guardian_last_name ?? '') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="guardian_contact_number">Contact Number:</label>
                    <input type="text" id="guardian_contact_number" name="guardian_contact_number"
                        value="{{ old('guardian_contact_number', $student->details->guardian_contact_number ?? '') }}"
                        pattern="[0-9]{11}">
                </div>

                <div class="form-group">
                    <label for="guardian_relationship">Relationship to Student:</label>
                    <input type="text" id="guardian_relationship" name="guardian_relationship"
                        value="{{ old('guardian_relationship', $student->details->guardian_relationship ?? '') }}">
                </div>
            </div>

            <h3 class="section-header">Academic Information</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="year_level">Year Level:</label>
                    <select id="year_level" name="year_level" required>
                        <option value="11" {{ old('year_level', $student->year_level) == 11 ? 'selected' : '' }}>Grade
                            11</option>
                        <option value="12" {{ old('year_level', $student->year_level) == 12 ? 'selected' : '' }}>Grade
                            12</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" value="{{ old('status', $student->status) }}" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="strand_id">Strand:</label>
                    <select id="strand_id" name="strand_id" required>
                        @foreach(App\Models\Strand::all() as $strand)
                        <option value="{{ $strand->id }}"
                            {{ old('strand_id', $student->strand_id) == $strand->id ? 'selected' : '' }}>
                            {{ $strand->name }} ({{ $strand->code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                @if($student->type == 'transferee')
                <div class="form-group">
                    <label for="previous_school">Previous School:</label>
                    <input type="text" id="previous_school" name="previous_school"
                        value="{{ old('previous_school', $student->previous_school) }}">
                </div>
                @endif
            </div>

            @if($student->type == 'old')
            <div class="form-group">
                <label for="subjects">Subjects Taken:</label>
                <textarea id="subjects"
                    name="SubjectsTaken">{{ old('SubjectsTaken', $student->SubjectsTaken) }}</textarea>
            </div>
            @endif

            <!-- Documents Section -->
            <h3 class="section-header">Documents</h3>

            @if($student->type == 'old')
            <!-- Clearance File -->
            <div class="form-group" style="margin-bottom: 1rem;">
                <label for="grade_file">Clearance from Previous Semester:</label>
                @if($student->grade_file_url)
                <div style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    @if(Str::endsWith($student->grade_file_url, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ asset('storage/' . $student->grade_file_url) }}" alt="Clearance File"
                        style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                    @else
                    <a href="{{ asset('storage/' . $student->grade_file_url) }}" target="_blank"
                        style="color: #d32f2f; text-decoration: underline; display: inline-block;">View Attached
                        File</a>
                    @endif
                </div>
                @else
                <p style="color: #6c757d; margin-top: 0.5rem;">No attachment available</p>
                @endif

                <label for="grade_file_upload" style="margin-top: 0.5rem;">Upload New File:</label>
                <input type="file" id="grade_file_upload" name="grade_file_upload"
                    style="padding: 0.5rem 0; border: none;">
            </div>
            @endif

            @if($student->type == 'transferee')
            <div class="form-row">
                <!-- Report Card -->
                <div class="form-group">
                    <label for="report_card">Report Card:</label>
                    @if($student->report_card_path)
                    <div style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                        <a href="{{ asset('storage/' . $student->report_card_path) }}" target="_blank"
                            style="color: #d32f2f; text-decoration: underline; display: inline-block;">View File</a>
                    </div>
                    @else
                    <p style="color: #6c757d; margin-top: 0.5rem;">No file available</p>
                    @endif

                    <label for="report_card_upload" style="margin-top: 0.5rem;">Upload New File:</label>
                    <input type="file" id="report_card_upload" name="report_card_upload"
                        style="padding: 0.5rem 0; border: none;">
                </div>

                <!-- Good Moral Certificate -->
                <div class="form-group">
                    <label for="good_moral">Good Moral Certificate:</label>
                    @if($student->good_moral_path)
                    <div style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                        <a href="{{ asset('storage/' . $student->good_moral_path) }}" target="_blank"
                            style="color: #d32f2f; text-decoration: underline; display: inline-block;">View File</a>
                    </div>
                    @else
                    <p style="color: #6c757d; margin-top: 0.5rem;">No file available</p>
                    @endif

                    <label for="good_moral_upload" style="margin-top: 0.5rem;">Upload New File:</label>
                    <input type="file" id="good_moral_upload" name="good_moral_upload"
                        style="padding: 0.5rem 0; border: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="birth_certificate">Birth Certificate:</label>
                @if($student->birth_certificate_path)
                <div style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <a href="{{ asset('storage/' . $student->birth_certificate_path) }}" target="_blank"
                        style="color: #d32f2f; text-decoration: underline; display: inline-block;">View File</a>
                </div>
                @else
                <p style="color: #6c757d; margin-top: 0.5rem;">No file available</p>
                @endif

                <label for="birth_certificate_upload" style="margin-top: 0.5rem;">Upload New File:</label>
                <input type="file" id="birth_certificate_upload" name="birth_certificate_upload"
                    style="padding: 0.5rem 0; border: none;">
            </div>
            @endif

            <!-- Status Update Buttons -->
            <div class="form-group" style="display: flex; justify-content: space-between; gap: 1rem; margin-top: 1rem;">
                <button type="button" class="btn" style="background-color: #28a745; flex: 1;"
                    onclick="updateStatus('PASSED')">Mark as Passed</button>
                <button type="button" class="btn" style="background-color: #dc3545; flex: 1;"
                    onclick="updateStatus('FAILED')">Mark as Failed</button>
            </div>

            <!-- Update Student Button -->
            <button type="submit" style="margin-top: 1rem;">Update Student</button>

            <script>
                function updateStatus(status) {
                    document.getElementById('status').value = status;
                }
            </script>
        </form>
        <a href="{{ route('admin.students.index') }}">Back to Students</a>
    </div>
</body>

</html>