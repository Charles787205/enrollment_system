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
            background: url('{{ asset(' images/um.png') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 600px;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Student</h1>

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

        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="date_of_birth"
                    value="{{ old('date_of_birth', $student->DateOfBirth) }}">
            </div>

            <div class="form-group">
                <label for="sex">Sex:</label>
                <select id="sex" name="sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male" {{ old('sex', $student->Sex) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex', $student->Sex) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone_number"
                    value="{{ old('phone_number', $student->PhoneNumber) }}">
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address', $student->Address) }}">
            </div>

            <div class="form-group">
                <label for="year_level">Year Level:</label>
                <select id="year_level" name="year_level" required>
                    <option value="11" {{ $student->year_level == 11 ? 'selected' : '' }}>11</option>
                    <option value="12" {{ $student->year_level == 12 ? 'selected' : '' }}>12</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" value="{{ $student->status }}" readonly>
            </div>

            <div class="form-group">
                <label for="strand_id">Strand:</label>
                <select id="strand_id" name="strand_id" required>
                    @foreach(App\Models\Strand::all() as $strand)
                    <option value="{{ $strand->id }}" {{ $student->strand_id == $strand->id ? 'selected' : '' }}>
                        {{ $strand->name }} ({{ $strand->code }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subjects">Subjects Taken:</label>
                <textarea id="subjects" name="SubjectsTaken">{{ $student->SubjectsTaken }}</textarea>
            </div>

            <div class="form-group" style="margin-top: 2rem;">
                <h3 style="color: #d32f2f; border-bottom: 2px solid #d32f2f; padding-bottom: 0.5rem;">Attach
                    Requirements</h3>



                <!-- Clearance File -->
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="clearance_file">Clearance from Previous Semester:</label>
                    @if($student->grade_file_url)
                    @if(Str::endsWith($student->grade_file_url, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ asset('storage/' . $student->grade_file_url) }}" alt="Clearance File"
                        style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; margin-top: 0.5rem;">
                    @else
                    <a href="{{ asset('storage/' . $student->grade_file_url) }}" target="_blank"
                        style="color: #d32f2f; text-decoration: underline;">View Attached File</a>
                    @endif
                    @else
                    <p style="color: #6c757d;">No attachment available</p>
                    @endif
                </div>
            </div>

            <!-- Passed and Failed Buttons -->
            <div class="form-group" style="display: flex; justify-content: space-between; gap: 1rem; margin-top: 1rem;">
                <button type="button" class="btn"
                    style="background-color: #28a745; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px;"
                    onclick="updateStatus('PASSED')">Passed</button>
                <button type="button" class="btn"
                    style="background-color: #dc3545; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px;"
                    onclick="updateStatus('FAILED')">Failed</button>
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