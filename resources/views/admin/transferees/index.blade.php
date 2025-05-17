<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transferee Applications - Admin Dashboard</title>
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

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
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
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }

        .modal-content {
            position: relative;
            margin: auto;
            padding: 20px;
            width: 90%;
            max-width: 800px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border-radius: 8px;
        }

        #modalImage {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            max-height: 80vh;
            object-fit: contain;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            color: #333;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background: white;
            border-radius: 50%;
        }

        .close:hover {
            color: #d32f2f;
            background: #f8f9fa;
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

        /* Enroll Button Styling */
        button.btn-enroll {
            padding: 0.6rem 1.2rem;
            background-color: #4CAF50;
            /* Green background */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button.btn-enroll:hover {
            background-color: #45a049;
            /* Darker green on hover */
            transform: scale(1.05);
            /* Slightly enlarge the button on hover */
        }

        button.btn-enroll:focus {
            outline: none;
        }

        button.btn-enroll:active {
            background-color: #388e3c;
            /* Even darker green on click */
            transform: scale(1);
            /* Remove scale on click */
        }

        .status {
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.85rem;
            display: inline-center;
            min-width: 80px;
            text-align: center;
        }

        .status.enrolled {
            background-color: #4CAF50;
            color: white;
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.2);
            /* Subtle shadow */
        }

        .status.pending {
            background-color: #f0ad4e;
            color: white;
            box-shadow: 0 2px 4px rgba(240, 173, 78, 0.2);
            /* Subtle shadow */
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
        <div class="transferee-table">
            <h1>Transferee Applications</h1>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Previous School</th>
                        <th>Strand</th>
                        <th>Documents</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transferees as $transferee)
                    <tr>
                        <td>{{ $transferee->first_name }} {{ $transferee->middle_name }} {{ $transferee->last_name }}
                        </td>
                        <td>{{ $transferee->email }}</td>
                        <td>{{ $transferee->previous_school }}</td>
                        <td>{{ $transferee->strand ? $transferee->strand->name : 'N/A' }}</td>
                        <td>
                            <a href="#" class="document-link"
                                data-image="{{ asset('storage/' . $transferee->report_card_path) }}">
                                <i class="fas fa-file-alt"></i> Report Card
                            </a><br>
                            <a href="#" class="document-link"
                                data-image="{{ asset('storage/' . $transferee->good_moral_path) }}">
                                <i class="fas fa-file-alt"></i> Good Moral
                            </a><br>
                            <a href="#" class="document-link"
                                data-image="{{ asset('storage/' . $transferee->birth_certificate_path) }}">
                                <i class="fas fa-file-alt"></i> Birth Certificate
                            </a>
                        </td>
                        <td>{{ $transferee->created_at->format('M d, Y') }}</td>
                        <td class="status {{ strtolower($transferee->status) == 'enrolled' ? 'enrolled' : 'pending' }}">
                            {{ $transferee->status }}
                        </td>
                        <td>
                            @if(strtolower($transferee->status) != 'enrolled')
                            <form action="{{ route('admin.transferees.enroll', $transferee->id) }}" method="POST"
                                class="enroll-form" data-transferee-id="{{ $transferee->id }}">
                                @csrf
                                <button type="submit" class="btn-enroll">Enroll</button>
                            </form>
                            @else
                            <button class="btn-enroll" disabled>Accepted</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No transferee applications found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $transferees->links('vendor.pagination.default') }}
        </div>
    </div>

    <!-- Modal to show image -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="Document Preview">
        </div>
    </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        const closeBtn = document.querySelector(".close");

        // When any document link is clicked
        document.querySelectorAll(".document-link").forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const imageUrl = this.getAttribute("data-image");

                // Show loading state
                modalImg.src = ""; // Clear previous image
                modal.style.display = "block";

                // Load new image
                modalImg.onload = function () {
                    // Image loaded successfully
                    this.style.display = "block";
                };

                modalImg.onerror = function () {
                    // Handle image load error
                    this.style.display = "none";
                    alert("Error loading document. Please try again.");
                    modal.style.display = "none";
                };

                modalImg.src = imageUrl;
            });
        });

        // Close modal when clicking the X
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });

        // Close modal when clicking outside the modal content
        window.addEventListener("click", function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });

        // Close modal on escape key
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                modal.style.display = "none";
            }
        });
    });
</script>


</html>