<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strands Management</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General styles */
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
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 2rem;
            margin-left: 1rem;
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

        td.actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            align-items: center;
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
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: rgb(243, 96, 96);
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0056b3;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            width: 500px;
            max-width: 100%;
            position: relative;
        }

        .modal h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .modal input,
        .modal textarea,
        .modal select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .modal button {
            padding: 12px 25px;
            background-color: #d32f2f;
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        .modal button:hover {
            background-color: #c62828;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            color: #666;
            cursor: pointer;
            background: transparent;
            border: none;
            width: auto;
            height: auto;
            padding: 0;
            display: block;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #d32f2f;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-input {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            width: 300px;
        }

        .search-input i {
            color: #666;
            margin-right: 0.5rem;
        }

        .search-input input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 0.9rem;
        }

        .search-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #d32f2f;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background: #b71c1c;
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

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

    <div class="main-content">
        <div class="header">
            <h1>Strands Management</h1>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <form method="GET" action="{{ route('admin.strands.index') }}" class="search-container">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" name="search" placeholder="Search strands..."
                            value="{{ request('search') }}" onkeyup="searchStrands()">
                    </div>
                </form>
                <button class="btn" onclick="showModal()">
                    <i class="fas fa-plus"></i> Add New Strand
                </button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($strands as $strand)
                <tr>
                    <td>{{ $strand->name }}</td>
                    <td>{{ $strand->code }}</td>
                    <td>{{ $strand->description }}</td>
                    <td>{{ $strand->capacity }}</td>
                    <td>
                        <span class="status-badge status-{{ $strand->status }}">
                            {{ ucfirst($strand->status) }}
                        </span>
                    </td>
                    <td class="actions">
                        <button
                            onclick="editStrand('{{ $strand->id }}', '{{ $strand->name }}', '{{ $strand->code }}', '{{ addslashes($strand->description) }}', '{{ $strand->status }}', '{{ $strand->capacity }}')"
                            class="btn btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.strands.destroy', $strand) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Inside Add Strand Modal -->
    <div id="addStrandModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Add New Strand</h2>

            {{-- Display Validation Errors --}}
            @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.strands.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" value="{{ old('code') }}" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Capacity</label>
                    <input type="number" name="capacity" min="1" value="{{ old('capacity', 40) }}" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit">Add Strand</button>
            </form>
        </div>
    </div>

    <div id="editStrandModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Edit Strand</h2>
            <form id="editStrandForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" id="editCode" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="editDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label>Capacity</label>
                    <input type="number" name="capacity" id="editCapacity" min="1" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editStatus" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Show modal automatically if there are validation errors
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors -> any())
                document.getElementById('addStrandModal').style.display = 'flex';
            @endif
        });

        function showModal() {
            document.getElementById('addStrandModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addStrandModal').style.display = 'none';
            document.getElementById('editStrandModal').style.display = 'none';
        }


        function editStrand(id, name, code, description, status, capacity) {
            const form = document.getElementById('editStrandForm');
            form.action = `/admin/strands/${id}`;

            document.getElementById('editName').value = name;
            document.getElementById('editCode').value = code;
            document.getElementById('editDescription').value = description.replace(/\\'/g, "'");
            document.getElementById('editStatus').value = status;
            document.getElementById('editCapacity').value = capacity;

            document.getElementById('editStrandModal').style.display = 'flex';
        }

        // Add this event listener to prevent form submission issues
        document.getElementById('editStrandForm').addEventListener('submit', function (e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                return false;
            }
            return true;
        });
    </script>
</body>

</html>