<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>First-Time Admin Setup - University M.</title>
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
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
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .setup-container {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    h1 {
      color: #d32f2f;
      text-align: center;
      margin-bottom: 1rem;
    }

    .welcome-message {
      text-align: center;
      margin-bottom: 2rem;
      color: #555;
      font-size: 1.1rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: #333;
    }

    input {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 1rem;
    }

    .btn {
      width: 100%;
      padding: 0.75rem;
      background: #d32f2f;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #b71c1c;
    }

    .error {
      color: #d32f2f;
      margin-bottom: 1rem;
      padding: 0.75rem;
      background: #fee;
      border-radius: 4px;
    }

    .info-text {
      font-size: 0.9rem;
      color: #666;
      margin-top: 0.5rem;
    }
  </style>
</head>

<body>
  <div class="setup-container">
    <h1>Welcome to University M.</h1>
    <p class="welcome-message">No administrator account has been detected. Please create your admin account to get
      started.</p>

    @if($errors->any())
    <div class="error">
      {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('admin.setup.post') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Full Name <span style="color:#d32f2f">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
      </div>
      <div class="form-group">
        <label>Username <span style="color:#d32f2f">*</span></label>
        <input type="text" name="username" value="{{ old('username') }}" required>
        <p class="info-text">This will be used to log in to the admin panel.</p>
      </div>
      <div class="form-group">
        <label>Email <span style="color:#d32f2f">*</span></label>
        <input type="email" name="email" value="{{ old('email') }}" required>
      </div>
      <div class="form-group">
        <label>Password <span style="color:#d32f2f">*</span></label>
        <input type="password" name="password" required>
        <p class="info-text">Minimum 8 characters.</p>
      </div>
      <div class="form-group">
        <label>Confirm Password <span style="color:#d32f2f">*</span></label>
        <input type="password" name="password_confirmation" required>
      </div>
      <button type="submit" class="btn">Create Admin Account</button>
    </form>
  </div>
</body>

</html>