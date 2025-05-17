<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Subjects Management</title>
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


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            color: #1f2937;
        }

        .header-actions {
            display: flex;
            align-items: center;
        }



        .add-btn button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
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

        .alert-success {
            background-color: #d1fae5;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-left: 6px solid #10b981;
            border-radius: 4px;
            color: #065f46;
        }

        .action-buttons button {
            margin-right: 0.4rem;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-size: 0.85rem;
        }

        .edit-btn {
            background-color: #3b82f6;
        }

        .delete-btn {
            background-color: #ef4444;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            z-index: 1000;
            width: 400px;
            display: none;
        }

        .modal label {
            display: block;
            margin-top: 0.75rem;
            font-weight: 500;
        }

        .modal input,
        .modal select,
        .modal textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.25rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .modal button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .modal .close {
            background-color: #ef4444;
            margin-left: 0.5rem;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 999;
            display: none;
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

        .modal-close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #d32f2f;
        }


        .update-btn {
            background-color: #d32f2f !important;
            color: white;
            padding: 0.5rem 1.5rem !important;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background-color 0.3s ease;
            margin-top: 1.5rem;
            width: 100%;
        }

        .update-btn:hover {
            background-color: #b71c1c !important;
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
            <h1>Subjects</h1>
            <div class="header-actions">
                <form method="GET" action="{{ route('admin.subjects.index') }}" class="search-container">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search subjects..."
                            value="{{ request('search') }}">
                    </div>

                </form>
                <div class="add-btn-container">
                    <button onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add Subject
                    </button>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Grade Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->code }}</td>
                        <td>{{ $subject->title }}</td>
                        <td>{{ $subject->description }}</td>
                        <td>{{ $subject->grade_level }}</td>
                        <td class="action-buttons">
                            <button class="edit-btn" onclick="openEditModal({{ $subject->id }})"><i
                                    class="fas fa-edit"></i> Edit</button>
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" type="submit"><i class="fas fa-trash-alt"></i>
                                    Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>


    <!-- Add Modal -->
    <div id="add-modal" class="modal">
        <!-- Error Display Section for Add Modal -->
        @if ($errors->any())
        <div id="add-modal-errors" style="color: #d32f2f; margin-bottom: 15px;">
            <ul id="add-error-list" style="padding-left: 20px; margin: 0;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h2>Add Subject</h2>

        <!-- Error Display Section for Add Modal -->
        <div id="add-modal-errors" style="color: #d32f2f; margin-bottom: 15px; display: none;">
            <ul id="add-error-list" style="padding-left: 20px; margin: 0;"></ul>
        </div>

        <form action="{{ route('admin.subjects.store') }}" method="POST" id="add-subject-form">
            @csrf
            <div class="form-group">
                <label for="code">Subject Code</label>
                <input type="text" name="code" id="code" required>
            </div>

            <div class="form-group">
                <label for="title">Subject Title</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="grade_level">Grade Level</label>
                <select name="grade_level" id="grade_level" required>
                    <option value="">Select Grade Level</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit">Save Subject</button>
                <button type="button" class="close" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
        <span class="modal-close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Subject</h2>

        <!-- Error Display Section for Edit Modal -->
        <div id="edit-modal-errors" style="color: #d32f2f; margin-bottom: 15px; display: none;">
            <ul id="edit-error-list" style="padding-left: 20px; margin: 0;"></ul>
        </div>

        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <label for="edit_code">Code</label>
            <input type="text" name="code" id="edit_code" required>

            <label for="edit_title">Title</label>
            <input type="text" name="title" id="edit_title" required>

            <label for="edit_description">Description</label>
            <textarea name="description" id="edit_description" required></textarea>

            <label for="edit_grade_level">Grade Level</label>
            <select name="grade_level" id="edit_grade_level" required>
                <option value="Grade 11">Grade 11</option>
                <option value="Grade 12">Grade 12</option>
            </select>

            <button type="submit" class="update-btn">Update</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="closeModal()"></div>

    <script>
        // Modal control functions
        function openAddModal() {
            document.getElementById("add-modal").style.display = "block";
            document.getElementById("overlay").style.display = "block";
            // Clear any previous errors
            document.getElementById("add-modal-errors").style.display = "none";
            document.getElementById("add-error-list").innerHTML = "";
        }

        function closeModal() {
            document.getElementById("add-modal").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function openEditModal(subjectId) {
            // Clear any previous errors
            document.getElementById("edit-modal-errors").style.display = "none";
            document.getElementById("edit-error-list").innerHTML = "";

            // Fetch subject data
            fetch(`/admin/subjects/${subjectId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("edit_code").value = data.code;
                    document.getElementById("edit_title").value = data.title;
                    document.getElementById("edit_description").value = data.description;
                    document.getElementById("edit_grade_level").value = data.grade_level;

                    // Update form action URL
                    document.getElementById("edit-form").action = `/admin/subjects/${subjectId}`;

                    // Show the modal
                    document.getElementById("edit-modal").style.display = "block";
                    document.getElementById("overlay").style.display = "block";
                });
        }

        function closeEditModal() {
            document.getElementById("edit-modal").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        // Function to display errors in the add modal
        function displayAddErrors(errors) {
            const errorList = document.getElementById("add-error-list");
            errorList.innerHTML = ""; // Clear previous errors

            // Add each error to the list
            Object.values(errors).forEach(errorMessages => {
                errorMessages.forEach(message => {
                    const listItem = document.createElement("li");
                    listItem.textContent = message;
                    errorList.appendChild(listItem);
                });
            });

            // Show the error container
            document.getElementById("add-modal-errors").style.display = "block";
        }

        // Function to display errors in the edit modal
        function displayEditErrors(errors) {
            const errorList = document.getElementById("edit-error-list");
            errorList.innerHTML = ""; // Clear previous errors

            // Add each error to the list
            Object.values(errors).forEach(errorMessages => {
                errorMessages.forEach(message => {
                    const listItem = document.createElement("li");
                    listItem.textContent = message;
                    errorList.appendChild(listItem);
                });
            });

            // Show the error container
            document.getElementById("edit-modal-errors").style.display = "block";
        }

        // Add subject form submission
        const addForm = document.getElementById('add-subject-form');
        addForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Add form submitted');

            const formData = new FormData(addForm);

            // Get the CSRF token from the meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(addForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log(response)
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.errors) {
                        // Display validation errors
                        displayAddErrors(data.errors);
                    } else if (data.success) {
                        // Redirect or reload on success
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show a generic error message
                    displayAddErrors({ 'error': ['An unexpected error occurred. Please try again.'] });
                });
        });

        // Edit subject form submission
        const editForm = document.getElementById('edit-form');
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Edit form submitted');

            const formData = new FormData(editForm);

            // Get the CSRF token from the meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(editForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.errors) {
                        // Display validation errors
                        displayEditErrors(data.errors);
                    } else if (data.success) {
                        // Redirect or reload on success
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show a generic error message
                    displayEditErrors({ 'error': ['An unexpected error occurred. Please try again.'] });
                });
        });

        // Close modals when clicking overlay
        document.getElementById("overlay").onclick = function () {
            closeModal();
            closeEditModal();
        }

        // Close modals when pressing Escape key
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                closeModal();
                closeEditModal();
            }
        });
    </script>
</body>

</html>