<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sections - Admin Dashboard</title>
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
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .table-container {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        }

        .add-btn-container button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-btn,
        .delete-btn {
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .action-btn {
            background: #2196f3;
        }

        .delete-btn {
            background: #d32f2f;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 40%;
            position: relative;
        }

        .close {
            color: #aaa;
            position: absolute;
            right: 1rem;
            top: 0.5rem;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .modal-btn {
            background-color: #d32f2f;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-btn:hover {
            background-color: #b71c1c;
        }

        .highlighted {
            background-color: rgba(0, 123, 255, 0.2);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            margin: 0;
            color: #333;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            margin: 0;
            color: #333;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .add-btn-container button {
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

        .add-btn-container button:hover {
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
            <h1>Sections</h1>
            <div class="header-actions">
                <form method="GET" action="{{ route('admin.sections.index') }}" class="search-container">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" id="sectionSearch" name="search" placeholder="Search sections..."
                            value="{{ request('search') }}" onkeyup="searchSections()">
                    </div>
                </form>
                </form>
                <div class="add-btn-container">
                    <button onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add Section
                    </button>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table id="sectionsTable">
                <thead>
                    <tr>
                        <th>Section Name</th>
                        <th>Strand</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sections as $section)
                    <tr id="row-{{ $section->id }}">
                        <td>{{ $section->name }}</td>
                        <td>{{ $section->strand ? $section->strand->name . ' (' . $section->strand->code . ')' : 'N/A' }}
                        </td>
                        <td>{{ $section->capacity }}</td>
                        <td>
                            <button class="action-btn" onclick="openEditModal({{ $section->id }})"><i
                                    class="fas fa-edit"></i> Edit</button>
                            <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this section?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i>
                                    Delete</button>
                            </form>
                        </td>
                    </tr>

                    <div id="editModal-{{ $section->id }}" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeEditModal({{ $section->id }})">&times;</span>
                            <h2>Edit Section</h2>
                            <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="name">Section Name</label>
                                    <input type="text" name="name" value="{{ $section->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="strand_id">Strand</label>
                                    <select name="strand_id" required>
                                        <option value="">Select Strand</option>
                                        @foreach($strands as $strand)
                                        <option value="{{ $strand->id }}"
                                            {{ $section->strand_id == $strand->id ? 'selected' : '' }}>
                                            {{ $strand->name }} ({{ $strand->code }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="number" name="capacity" value="{{ $section->capacity }}" required>
                                </div>
                                <button type="submit" class="modal-btn">Update Section</button>
                            </form>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="4">No sections found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add Section</h2>
            <form action="{{ route('admin.sections.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Section Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label for="strand_id">Strand</label>
                    <select name="strand_id" required>
                        <option value="">Select Strand</option>
                        @foreach($strands as $strand)
                        <option value="{{ $strand->id }}">{{ $strand->name }} ({{ $strand->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" required>
                </div>
                <button type="submit" class="modal-btn">Add Section</button>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function openEditModal(sectionId) {
            document.getElementById('editModal-' + sectionId).style.display = 'block';
        }

        function closeEditModal(sectionId) {
            document.getElementById('editModal-' + sectionId).style.display = 'none';
        }

        function searchSections() {
            var input = document.getElementById("sectionSearch").value.toLowerCase();
            var table = document.getElementById("sectionsTable");
            var rows = table.getElementsByTagName("tr");
            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var sectionName = cells[0].textContent.toLowerCase();
                rows[i].style.display = sectionName.includes(input) ? "" : "none";
            }
        }
    </script>

</body>

</html>