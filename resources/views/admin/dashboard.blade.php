<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            border-right: 2px solid #ffffff;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
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

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .quick-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quick-actions a {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #d32f2f;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            justify-items: center;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 3rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 350px;
            width: 100%;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover {
            transform: scale(1.02);
        }

        .stat-card p {
            font-size: 4rem;
            font-weight: bold;
            color: #d32f2f;
            margin: 0;
        }

        .stat-card h3 {
            font-size: 2rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .chart-container {
            margin-top: 3rem;
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .modal-body table {
            width: 100%;
        }

        .modal-body th,
        .modal-body td {
            text-align: left;
            padding: 0.5rem;
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
<div class="logout-container">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="header-container">
            <h1>Welcome, {{ Auth::guard('admin')->user()->username }}</h1>
            <div class="quick-actions">
                <a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> View Old Student</a>
                <a href="{{ route('admin.transferees.index') }}"><i class="fas fa-users"></i> View Transferees</a>
                <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#viewAllStudentsModal"><i class="fas fa-list"></i> View All Students</a> -->
            </div>
        </div>

        <div class="stats-grid">
            <a href="#" class="stat-card">
                <h3>Total Students</h3>
                <p>{{ $stats['total_students'] ?? '0' }}</p>
            </a>
            <a href="{{ route('admin.students.index') }}" class="stat-card">
                <h3>Old Students</h3>
                <p>{{ $stats['old_students'] ?? '0' }}</p>
            </a>
            <a href="{{ route('admin.transferees.index') }}" class="stat-card">
                <h3>Transferees</h3>
                <p>{{ $stats['transferees'] ?? '0' }}</p>
            </a>
            <a href="{{ route('admin.strands.index') }}" class="stat-card">
                <h3>Total Strands</h3>
                <p>{{ $stats['total_strands'] ?? '0' }}</p>
            </a>
            <a href="{{ route('admin.faculty.index') }}" class="stat-card">
                <h3>Faculty Members</h3>
                <p>{{ $stats['faculty_members'] ?? '0' }}</p>
            </a>
        </div>

        <div class="chart-container">
            <h2 style="margin-bottom: 1rem;">Monthly Student Enrollments ({{ now()->year }})</h2>
            <canvas id="registrationChart" height="120"></canvas>
        </div>
    </div>

   <!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="viewAllStudentsModal" tabindex="-1" aria-labelledby="viewAllStudentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="viewAllStudentsLabel">All Students</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Strand</th>
                            <th>Year Level</th>
                            <th>Type</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($allStudents) && $allStudents->count() > 0) 
                            @foreach($allStudents as $student)
                                <tr>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->course }}</td>
                                    <td>{{ $student->year_level }}</td>
                                    <td>{{ ucfirst($student->type) }}</td> 
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No students available.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('registrationChart').getContext('2d');
        const registrationChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Student Enrollments',
                    data: @json($chartData),
                    backgroundColor: 'rgba(211, 47, 47, 0.2)',
                    borderColor: '#d32f2f',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
</body>

</html>
