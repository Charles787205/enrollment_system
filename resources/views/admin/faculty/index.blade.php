<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty - Admin Dashboard</title>
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



        .add-faculty-btn button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-faculty-btn button:hover {
            background-color: #b71c1c;
        }

        .transferee-table {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
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

        .transferee-table a {
            color: #2196f3;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
        <h1>Faculty Members</h1>
        <div class="header-actions">
         <form method="GET" action="{{ route('admin.faculty.index') }}" class="search-container">
    <div class="search-input">
        <i class="fas fa-search"></i>
        <input 
            type="text" 
            id="searchInput" 
            name="search" 
            placeholder="Search faculty..." 
            value="{{ request('search') }}"
            onkeyup="searchStrands()"
        >
    </div>
            </form>
            <div class="add-faculty-btn">
                <button onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add Faculty
                </button>
            </div>
        </div>
    </div>
  

    <div class="transferee-table">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Position</th>
                <th>Contact Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faculty as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->gender }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->position }}</td>
                    <td>{{ $member->contact_number }}</td>
                    <td>
                        <button type="button" onclick="openEditModal({{ $member->id }}, '{{ $member->name }}', '{{ $member->gender }}', '{{ $member->email }}', '{{ $member->position }}', '{{ $member->contact_number }}')" 
                        style="background:#2196f3; color:white; border:none; padding:0.4rem 0.75rem; border-radius:4px; cursor:pointer;">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.faculty.destroy', $member->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" style="background:#d32f2f; color:white; border:none; padding:0.4rem 0.75rem; border-radius:4px; cursor:pointer;">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No faculty members found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        {{ $faculty->links('pagination::bootstrap-4') }}  <!-- Using Bootstrap 4 pagination view -->
    </div>
</div>

    <!-- Pagination Links -->
    <div class="pagination">
        {{ $faculty->links('pagination::bootstrap-4') }}  <!-- Using Bootstrap 4 pagination view -->
    </div>
</div>


<!-- Faculty Modal -->
<div id="facultyModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Add Faculty</h2>
        <form id="facultyForm" method="POST" action="{{ route('admin.faculty.store') }}">
            @csrf
            <input type="hidden" name="_method" id="method" value="POST">
            <input type="hidden" name="edit_mode" id="editMode" value="false">
            <div style="margin-bottom:1rem;">
                <label>Name:</label><br>
                <input type="text" name="name" id="facultyName" required style="width:100%; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label>Gender:</label><br>
                <select name="gender" id="facultyGender" required style="width:100%; padding:0.5rem;">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label>Email:</label><br>
                <input type="email" name="email" id="facultyEmail" required style="width:100%; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label>Position:</label><br>
                <input type="text" name="position" id="facultyPosition" required style="width:100%; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label>Contact Number:</label><br>
                <input type="text" name="contact_number" id="facultyContactNumber" style="width:100%; padding:0.5rem;">
            </div>
            <button type="submit" style="background:#d32f2f; color:white; border:none; padding:0.5rem 1rem; border-radius:4px; cursor:pointer;">
                Save
            </button>
        </form>
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

<script>
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Add Faculty';
        document.getElementById('facultyForm').action = "{{ route('admin.faculty.store') }}";
        document.getElementById('method').value = 'POST';
        document.getElementById('facultyName').value = '';
        document.getElementById('facultyGender').value = '';
        document.getElementById('facultyEmail').value = '';
        document.getElementById('facultyPosition').value = '';
        document.getElementById('facultyContactNumber').value = '';
        document.getElementById('editMode').value = false;
        document.getElementById('facultyModal').style.display = 'block';
    }

    function openEditModal(id, name, gender, email, position, contact_number) {
        document.getElementById('modalTitle').innerText = 'Edit Faculty';
        document.getElementById('facultyForm').action = '/admin/faculty/' + id;
        document.getElementById('method').value = 'PUT';
        document.getElementById('facultyName').value = name;
        document.getElementById('facultyGender').value = gender;
        document.getElementById('facultyEmail').value = email;
        document.getElementById('facultyPosition').value = position;
        document.getElementById('facultyContactNumber').value = contact_number;
        document.getElementById('editMode').value = true;
        document.getElementById('facultyModal').style.display = 'block';
    }

    function confirmDelete() {
        return confirm('Are you sure you want to delete this faculty member?');
    }

    function closeModal() {
        document.getElementById('facultyModal').style.display = 'none';
    }
</script>
</body>

</html>
