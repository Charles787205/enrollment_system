<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Profile Settings</title>
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

    .container {
      max-width: 600px;
      background-color: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: #d32f2f;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      font-weight: 500;
      margin-bottom: 0.5rem;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    .btn {
      background-color: #d32f2f;
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      width: 100%;
      margin-top: 1rem;
    }

    .btn:hover {
      background-color: #b71c1c;
    }

    .alert {
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 6px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .alert ul {
      margin: 0;
      padding-left: 1.5rem;
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
        class="nav-link {{ Request::routeIs('admin.profileSettings.edit') ? 'active' : '' }}">
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
    <div class="container">
      <h2>Admin Profile Settings</h2>

      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif

      @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form action="{{ route('admin.profileSettings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Full Name -->
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" value="{{ auth()->user()->name }}" required />
        </div>

        <!-- Email -->
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" value="{{ auth()->user()->email }}" required />
        </div>

        <!-- Password -->
        <div class="form-group">
          <label>New Password <small>(leave blank to keep current)</small></label>
          <input type="password" name="password" />
        </div>

        <button type="submit" class="btn">Save Changes</button>
      </form>
    </div>
  </div>
</body>

</html>