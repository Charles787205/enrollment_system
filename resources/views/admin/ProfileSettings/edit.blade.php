<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Admin Dashboard</title>
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
            min-height: 100vh;
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

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
        }

        .card h1 {
            font-size: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .btn-submit {
            background-color: #d32f2f;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 2rem auto 0 auto;
        }

        .btn-submit:hover {
            background-color: #b71c1c;
        }

        .alert-success {
            background-color: #e6f4ea;
            color: #256029;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 2rem;
            }

            .card {
                padding: 2rem;
            }
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


    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

    <div class="main-content">
        <div class="card">
            <h1>Profile Settings</h1>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.profileSettings.update') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation">
                </div>

                <button type="submit" class="btn-submit">Save Changes</button>
            </form>
        </div>
    </div>
</body>

</html>
