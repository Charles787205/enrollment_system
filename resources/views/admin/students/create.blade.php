<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Student</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #f8f9fa;
            display: flex;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100%;
            background: #d32f2f;
            padding: 3rem 1.5rem;
            color: white;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            transition: background 0.3s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            padding: 3rem;
            width: 100%;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #d32f2f;
            outline: none;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #d32f2f;
            color: white;
        }

        .btn-primary:hover {
            background-color: #b71c1c;
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: #d32f2f;
            border: 1px solid #d32f2f;
        }

        .btn-secondary:hover {
            background-color: #f1f1f1;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 6px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .logout-btn {
            position: fixed;
            bottom: 20px;
            left: 70px;
            background: white;
            color: #d32f2f;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #f8d7da;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: #d32f2f;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #999;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <nav>
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.enrollment.index') }}"
                class="nav-link {{ Request::routeIs('admin.enrollment.index') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Enrollment
            </a>
            <a href="{{ route('admin.students.index') }}"
                class="nav-link {{ Request::routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Old Students
            </a>
            <a href="{{ route('admin.transferees.index') }}"
                class="nav-link {{ Request::routeIs('admin.transferees.index') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Transferees
            </a>
            <a href="{{ route('admin.strands.index') }}"
                class="nav-link {{ Request::routeIs('admin.strands.index') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Strands
            </a>
            <a href="{{ route('admin.faculty.index') }}"
                class="nav-link {{ Request::routeIs('admin.faculty.index') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Faculty
            </a>
            <a href="{{ route('admin.sections.index') }}"
                class="nav-link {{ Request::routeIs('admin.sections.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Sections
            </a>
            <a href="{{ route('admin.subjects.index') }}"
                class="nav-link {{ Request::routeIs('admin.subjects.index') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i> Subjects
            </a>
            <a href="{{ route('admin.profileSettings.edit') }}"
                class="nav-link {{ Request::routeIs('admin.profileSettings.edit') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Profile Settings
            </a>
        </nav>
    </div>

    <div class="logout-container">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="breadcrumb-separator">></span>
                <a href="{{ route('admin.students.index') }}">Students</a>
                <span class="breadcrumb-separator">></span>
                <span>Add New Student</span>
            </div>
            <h1>Add New Student</h1>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-container">
            <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden field to identify this as an 'old' student -->
                <input type="hidden" name="type" value="old">

                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id"
                        value="{{ old('student_id') }}" required>
                </div>
                <!-- Personal Information -->
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ old('first_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                        value="{{ old('middle_name') }}">
                    <small class="text-muted">Optional</small>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ old('last_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number"
                        value="{{ old('contact_number') }}" pattern="[0-9]{11}" required>
                    <small class="text-muted">11-digit phone number (e.g., 09123456789)</small>
                </div>
                <div class="form-group">
                    <label for="DateOfBirth">Date of Birth</label>
                    <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth"
                        value="{{ old('DateOfBirth') }}" required>
                </div>
                <div class="form-group">
                    <label for="Sex">Gender</label>
                    <select class="form-control" id="Sex" name="Sex" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('Sex') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('Sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Academic Information -->
                <div class="form-group">
                    <label for="year_level">Year Level</label>
                    <select class="form-control" id="year_level" name="year_level" required>
                        <option value="">Select Year Level</option>
                        <option value="11" {{ old('year_level') == '11' ? 'selected' : '' }}>Grade 11</option>
                        <option value="12" {{ old('year_level') == '12' ? 'selected' : '' }}>Grade 12</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="strand_id">Strand</label>
                    <select class="form-control" id="strand_id" name="strand_id" required>
                        <option value="">Select Strand</option>
                        @foreach(App\Models\Strand::all() as $strand)
                        <option value="{{ $strand->id }}" {{ old('strand_id') == $strand->id ? 'selected' : '' }}>
                            {{ $strand->name }} ({{ $strand->code }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">Select Status</option>
                        <option value="ENROLLED" {{ old('status') == 'ENROLLED' ? 'selected' : '' }}>ENROLLED</option>
                        <option value="PENDING" {{ old('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                        <option value="PASSED" {{ old('status') == 'PASSED' ? 'selected' : '' }}>PASSED</option>
                        <option value="FAILED" {{ old('status') == 'FAILED' ? 'selected' : '' }}>FAILED</option>
                    </select>
                </div>

                <!-- Address Information (StudentDetail) -->
                <h3 style="margin-top: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Address
                    Information</h3>

                <div class="form-group">
                    <label for="street">Street Address</label>
                    <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" value="{{ old('barangay') }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="city">City/Municipality</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                </div>
                <div class="form-group">
                    <label for="province">Province</label>
                    <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                        value="{{ old('postal_code') }}" pattern="[0-9]{4}" required>
                    <small class="text-muted">4-digit code (e.g., 1234)</small>
                </div>

                <!-- Parent/Guardian Information (StudentDetail) -->
                <h3 style="margin-top: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Parent/Guardian
                    Information</h3>

                <div class="form-group">
                    <label for="father_first_name">Father's First Name</label>
                    <input type="text" class="form-control" id="father_first_name" name="father_first_name"
                        value="{{ old('father_first_name') }}">
                </div>
                <div class="form-group">
                    <label for="father_middle_name">Father's Middle Name</label>
                    <input type="text" class="form-control" id="father_middle_name" name="father_middle_name"
                        value="{{ old('father_middle_name') }}">
                </div>
                <div class="form-group">
                    <label for="father_last_name">Father's Last Name</label>
                    <input type="text" class="form-control" id="father_last_name" name="father_last_name"
                        value="{{ old('father_last_name') }}">
                </div>
                <div class="form-group">
                    <label for="father_contact_number">Father's Contact Number</label>
                    <input type="text" class="form-control" id="father_contact_number" name="father_contact_number"
                        value="{{ old('father_contact_number') }}" pattern="[0-9]{11}">
                    <small class="text-muted">11-digit phone number (e.g., 09123456789)</small>
                </div>
                <div class="form-group">
                    <label for="father_occupation">Father's Occupation</label>
                    <input type="text" class="form-control" id="father_occupation" name="father_occupation"
                        value="{{ old('father_occupation') }}">
                </div>

                <hr style="margin: 20px 0;">

                <div class="form-group">
                    <label for="mother_first_name">Mother's First Name</label>
                    <input type="text" class="form-control" id="mother_first_name" name="mother_first_name"
                        value="{{ old('mother_first_name') }}">
                </div>
                <div class="form-group">
                    <label for="mother_middle_name">Mother's Middle Name</label>
                    <input type="text" class="form-control" id="mother_middle_name" name="mother_middle_name"
                        value="{{ old('mother_middle_name') }}">
                </div>
                <div class="form-group">
                    <label for="mother_last_name">Mother's Last Name</label>
                    <input type="text" class="form-control" id="mother_last_name" name="mother_last_name"
                        value="{{ old('mother_last_name') }}">
                </div>
                <div class="form-group">
                    <label for="mother_contact_number">Mother's Contact Number</label>
                    <input type="text" class="form-control" id="mother_contact_number" name="mother_contact_number"
                        value="{{ old('mother_contact_number') }}" pattern="[0-9]{11}">
                    <small class="text-muted">11-digit phone number (e.g., 09123456789)</small>
                </div>
                <div class="form-group">
                    <label for="mother_occupation">Mother's Occupation</label>
                    <input type="text" class="form-control" id="mother_occupation" name="mother_occupation"
                        value="{{ old('mother_occupation') }}">
                </div>

                <hr style="margin: 20px 0;">

                <div class="form-group">
                    <label for="guardian_first_name">Guardian's First Name (if different from parents)</label>
                    <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name"
                        value="{{ old('guardian_first_name') }}">
                </div>
                <div class="form-group">
                    <label for="guardian_last_name">Guardian's Last Name</label>
                    <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name"
                        value="{{ old('guardian_last_name') }}">
                </div>
                <div class="form-group">
                    <label for="guardian_contact_number">Guardian's Contact Number</label>
                    <input type="text" class="form-control" id="guardian_contact_number" name="guardian_contact_number"
                        value="{{ old('guardian_contact_number') }}" pattern="[0-9]{11}">
                    <small class="text-muted">11-digit phone number (e.g., 09123456789)</small>
                </div>
                <div class="form-group">
                    <label for="guardian_relationship">Relationship to Student</label>
                    <input type="text" class="form-control" id="guardian_relationship" name="guardian_relationship"
                        value="{{ old('guardian_relationship') }}">
                    <small class="text-muted">e.g., Aunt, Uncle, Grandparent</small>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Save Student</button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>