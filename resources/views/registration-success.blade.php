<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
    <style>
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<h1>Welcome to Success Page!</h1>

@if (session('success'))
    <h2>{{ session('success') }}</h2>
@else
    <h2>No session success found</h2>
@endif


<h1>✅ Registration Completed!</h1>
<p>Your clearance was uploaded successfully.</p>
<a href="/">Back to Home</a>

</body>
</html>
