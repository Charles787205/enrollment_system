<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - University M.</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: rgba(0, 0, 0, 0.5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        .modal-header {
            background-color: #d32f2f;
            color: white;
            padding: 1rem;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
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

        .toggle-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #666;
            text-decoration: none;
            cursor: pointer;
        }

        .toggle-link:hover {
            color: #d32f2f;
        }

        .error {
            color: #d32f2f;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #fee;
            border-radius: 4px;
        }

    .success {
        color: #155724;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: #d4edda;
        border-radius: 4px;
    }

    .error {
        color: #d32f2f;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: #fee;
        border-radius: 4px;
    }
    </style>
</head>

<body>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Admin Registration</h2>
        </div>
        <div class="modal-body">
    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

<form action="{{ route('admin.register.submit') }}" method="POST" class="admin-form">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
    </div>
    <button type="submit" class="admin-login-btn">Register</button>
</form>
</body>

</html>