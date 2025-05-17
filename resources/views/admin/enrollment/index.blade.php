<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment - Admin Dashboard</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 0;
        }

        .search-form {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.3rem 0.5rem;
        }

        .search-form input {
            border: none;
            outline: none;
            padding: 0.4rem;
            font-size: 0.9rem;
        }

        .search-form button {
            background: none;
            border: none;
            cursor: pointer;
            color: #555;
            font-size: 1rem;
        }

        .add-enrollment-btn button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-enrollment-btn button:hover {
            background-color: #b71c1c;
        }

        .transferee-table {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-top: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            font-weight: 600;
            color: #666;
            background-color: #f1f1f1;
        }

        td {
            color: #333;
        }

        .actions button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .actions button:hover {
            background-color: #b71c1c;
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

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
            font-size: 0.875rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.4rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .pagination .active {
            background-color: #d32f2f;
            color: white;
            border-color: #d32f2f;
            font-weight: bold;
        }

        .pagination .disabled {
            color: #999;
            cursor: not-allowed;
        }

        /* Modal Styles */
        #transfereeModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .modal-content span.close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .modal-content p {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="sidebar">
    <h2>Admin Panel</h2>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.enrollment.index') }}" class="nav-link {{ Request::routeIs('admin.enrollment.index') ? 'active' : '' }}">
            <i class="fas fa-user-check"></i> Enrollment
        </a>
        <a href="{{ route('admin.students.index') }}" class="nav-link {{ Request::routeIs('admin.students.index') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i> Old Students
        </a>
        <a href="{{ route('admin.transferees.index') }}" class="nav-link {{ Request::routeIs('admin.transferees.index') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Transferees
        </a>
        <a href="{{ route('admin.strands.index') }}" class="nav-link {{ Request::routeIs('admin.strands.index') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Strands
        </a>
        <a href="{{ route('admin.faculty.index') }}" class="nav-link {{ Request::routeIs('admin.faculty.index') ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher"></i> Faculty
        </a>
        <a href="{{ route('admin.sections.index') }}" class="nav-link {{ Request::routeIs('admin.sections.index') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Sections
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="nav-link {{ Request::routeIs('admin.subjects.index') ? 'active' : '' }}">
            <i class="fas fa-book-open"></i> Subjects
        </a>
        <a href="{{ route('admin.profileSettings.edit') }}" class="nav-link {{ Request::routeIs('admin.admin.profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i> Profile Settings
        </a>
    </nav>
</div>

    <div class="main-content">
        <div class="header">
            <h1>Enrollments</h1>
            <div class="header-actions">
                <form method="GET" action="{{ route('admin.transferees.index') }}" class="search-form">
                    <input type="text" name="search" placeholder="Search transferees..." value="{{ request('search') }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="transferee-table">
            <h2>Transferee Enrolled</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Grade Level</th>
                            <th>Program</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transferees as $transferee)
                        <tr>
                            <td>{{ $transferee->id }}</td>
                            <td>{{ $transferee->full_name }}</td>
                            <td>{{ $transferee->academic_year }}</td>
                            <td>{{ $transferee->program }}</td>
                            <td class="actions">
                                <button onclick="openModal({{ $transferee->id }}, '{{ e($transferee->full_name) }}', '{{ $transferee->academic_year }}', '{{ $transferee->program }}', '{{ $transferee->subject }}', '{{ $transferee->email }}', '{{ $transferee->contact_number }}', '{{ $transferee->previous_school }}')">
                                    Show Details
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="logout-container">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <!-- Modal -->
    <div id="transfereeModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Transferee Details</h2>
            <p><strong>ID:</strong> <span id="modal-id"></span></p>
            <p><strong>Full Name:</strong> <span id="modal-name"></span></p>
            <p><strong>Grade Level:</strong> <span id="modal-grade"></span></p>
            <p><strong>Program:</strong> <span id="modal-program"></span></p>
            <p><strong>Email:</strong> <span id="modal-email"></span></p>
            <p><strong>Contact Number:</strong> <span id="modal-contact"></span></p>
            <p><strong>Previous School:</strong> <span id="modal-school"></span></p>
            <!-- <p><strong>Report Card:</strong> <span id="modal-report-card"></span></p>
            <p><strong>Good Moral:</strong> <span id="modal-good-moral"></span></p>
            <p><strong>Birth Certificate:</strong> <span id="modal-birth-cert"></span></p> -->
        </div>
    </div>

    <script>
        function openModal(id, name, grade, program, subject, email, contact, school, reportCard, goodMoral, birthCert) {
            document.getElementById('modal-id').textContent = id;
            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-grade').textContent = grade;
            document.getElementById('modal-program').textContent = program;
            document.getElementById('modal-email').textContent = email;
            document.getElementById('modal-contact').textContent = contact;
            document.getElementById('modal-school').textContent = school;
            // document.getElementById('modal-report-card').textContent = reportCard;
            // document.getElementById('modal-good-moral').textContent = goodMoral;
            // document.getElementById('modal-birth-cert').textContent = birthCert;
            document.getElementById('transfereeModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('transfereeModal').style.display = 'none';
        }
    </script>
</body>

</html>
