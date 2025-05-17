<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Management</title>
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
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        }

        th.actions {
            text-align: center;
            vertical-align: middle;
        }

        td.actions {
            text-align: center;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 0.5rem 1rem;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn:hover {
            background-color: rgb(243, 96, 96);
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
            align-items: center;
            justify-content: center;
        }

        .logout-btn:hover {
            background-color: #f8d7da;
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .clear-btn {
            background-color: #f8f9fa;
            color: #d32f2f;
            border: 1px solid #d32f2f;
        }

        .clear-btn:hover {
            background-color: #f1f1f1;
        }

        .filters {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .filters .form-control {
            padding: 0.4rem 0.6rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            background-color: #d32f2f;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: rgb(243, 96, 96);
        }

        .pagination .active {
            background-color: rgb(243, 96, 96);
            font-weight: bold;
        }


        .btn-group {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-group .btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.875rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-group .btn-view {
            background-color: #fd7e14;
            /* Orange */
        }

        .btn-group .btn-view:hover {
            background-color: #ff9843;
        }

        .btn-group .btn-edit {
            background-color: #0d6efd;
            /* Blue */
        }

        .btn-group .btn-edit:hover {
            background-color: #3d8bfd;
        }

        .btn-group .btn-delete {
            background-color: #d32f2f;
            /* Red */
        }

        .btn-group .btn-delete:hover {
            background-color: #b71c1c;
        }

        td.actions {
            padding: 0.75rem;
        }

        .btn-group form {
            margin: 0;
        }

        <style>

        /* Add to existing styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group .form-control {
            width: 100%;
        }

        .modal-footer {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
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
                class="nav-link {{ Request::routeIs('admin.students.index') ? 'active' : '' }}">
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
                class="nav-link {{ Request::routeIs('admin.admin.profile.edit') ? 'active' : '' }}">
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
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Header and Filter -->
        <div class="header">
            <h1>Students Management</h1>
            <div class="filters">
                <form method="GET" action="{{ route('admin.students.index') }}"
                    style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <input type="text" name="search" class="form-control" placeholder="Search by Name or ID"
                        value="{{ request('search') }}">
                    <select name="year_level" class="form-control">
                        <option value="">All Year Levels</option>
                        <option value="11" {{ request('year_level') == '11' ? 'selected' : '' }}>Grade 11</option>
                        <option value="12" {{ request('year_level') == '12' ? 'selected' : '' }}>Grade 12</option>
                    </select>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="PASSED" {{ request('status') == 'PASSED' ? 'selected' : '' }}>Passed</option>
                        <option value="FAILED" {{ request('status') == 'FAILED' ? 'selected' : '' }}>Failed</option>
                    </select>
                    <select name="strand" class="form-control">
                        <option value="">All Strands</option>
                        <option value="STEM" {{ request('strand') == 'STEM' ? 'selected' : '' }}>STEM</option>
                        <option value="ABM" {{ request('strand') == 'ABM' ? 'selected' : '' }}>ABM</option>
                        <option value="HUMSS" {{ request('strand') == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                        <option value="TVL" {{ request('strand') == 'TVL' ? 'selected' : '' }}>TVL</option>
                        <option value="GAS" {{ request('strand') == 'GAS' ? 'selected' : '' }}>GAS</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.students.index') }}" class="btn clear-btn">Clear</a>
                    <a href="{{ route('admin.students.create') }}" class="btn" style="margin-right: 1rem;">
                        <i class="fas fa-plus"></i> Add Student
                    </a>
                    <form method="GET" action="{{ route('admin.students.index') }}"
                        style="display: flex; gap: 0.5rem; flex-wrap: wrap;">

                    </form>
            </div>
        </div>

        <!-- Students Table -->
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Year Level</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Strand</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->year_level == 11 ? 'Grade 11' : 'Grade 12' }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->status }}</td>
                    <td>{{ $student->strand->name }}</td>
                    <td class="actions">
                        <div class="btn-group">
                            <button onclick="window.location.href='{{ route('admin.students.show', $student->id) }}'"
                                class="btn btn-sm btn-view">
                                <i class="fas fa-eye"></i>View
                            </button>
                            <button onclick="window.location.href='{{ route('admin.students.edit', $student->id) }}'"
                                class="btn btn-sm btn-edit">
                                <i class="fas fa-edit"></i>Edit
                            </button>
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this student?')">
                                    <i class="fas fa-trash"></i>Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            {{ $students->links() }}

        </div>
    </div>


    <script>
        // Get the modal
        const modal = document.getElementById('addStudentModal');
        const span = document.getElementsByClassName('close')[0];

        // Function to open modal
        function openModal() {
            modal.style.display = 'block';
        }

        // Function to close modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Close modal when clicking on X
        span.onclick = closeModal;

        // Close modal when clicking outside
        window.onclick = function (event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>