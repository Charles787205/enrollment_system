<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard - University M.</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: url('{{ asset('images/um.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #d32f2f;
            padding: 1.5rem 2rem;
            color: white;
        }

        .login-container {
            max-width: 400px;
            margin: 4rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #d32f2f;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .btn {
            background-color: #d32f2f;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #b71c1c;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .back-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: #666;
            text-decoration: none;
        }

        .back-link:hover {
            color: #d32f2f;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            color: #666;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .forgot-password a:hover {
            color: #d32f2f;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            /* Add transparency */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome-section {
            background: rgba(255, 255, 255, 0.9);
            /* Add transparency */
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h2>Student Dashboard</h2>
        <form action="/logout" method="POST" style="margin: 0">
            @csrf
            <button type="submit" class="btn logout-btn">Logout</button>
        </form>
    </div>

    <div class="dashboard-container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="welcome-section">
            <h1>Welcome, {{ $student->name }}!</h1>
            <p>Student ID: {{ $student->student_id }}</p>
            <p>Course: {{ $student->course }}</p>
            <p>Year Level: {{ $student->year_level }}</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Current Semester</h3>
                <p>2nd Semester 2024-2025</p>
            </div>
            <div class="stat-card">
                <h3>Enrolled Units</h3>
                <p>21 Units</p>
            </div>
            <div class="stat-card">
                <h3>Grade Point Average</h3>
                <p>3.5</p>
            </div>
        </div>
    </div>
</body>

</html>