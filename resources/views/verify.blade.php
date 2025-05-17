<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Verification - University M.</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .navbar {
            background: #d32f2f;
            padding: 1rem 2rem;
            color: white;
        }
        .verify-container {
            max-width: 500px;
            margin: 4rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn {
            background: #d32f2f;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .loading {
            display: none;
            text-align: center;
            margin-top: 0.5rem;
            color: #666;
        }
        .message {
            margin-top: 0.5rem;
            padding: 0.75rem;
            border-radius: 4px;
            text-align: center;
        }
        .error-message {
            background: #ffebee;
            color: #d32f2f;
        }
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #666;
            text-decoration: none;
        }
        .back-link:hover {
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>University M.</h2>
    </div>

    <div class="verify-container">
        <h1>Student Verification</h1>
        <form id="verifyForm">
           
            <div class="form-group">
                <label for="student_id">Enter your Student ID</label>
                <input type="text" id="student_id" name="student_id" required>
                <div class="loading">Verifying student ID...</div>
                <div class="error-message"></div>
            </div>
            <button type="submit" class="btn">Verify & Continue</button>
        </form>
        <a href="/" class="back-link">← Back to Home</a>
    </div>

    <script>
    $(document).ready(function() {
        $('#verifyForm').on('submit', function(e) {
            e.preventDefault();
            const studentId = $('#student_id').val();
            
            if (studentId.length >= 5) {
                $('.loading').show();
                $('.error-message').text('');
                
                $.ajax({
                    url: '{{ route("verify") }}', // Updated route name
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { student_id: studentId },
                    success: function(response) {
                        $('.loading').hide();
                        if (response.found) {
                            $('.message')
                                .removeClass('error-message')
                                .addClass('success-message')
                                .text('Student verified successfully!');
                            
                            // Redirect to registration form after 1 second
                            setTimeout(function() {
                                window.location.href = '{{ route("old-student") }}'; // Updated route name
                            }, 1000);
                        } else {
                            $('.error-message').text('Student ID not found. Please check and try again.');
                        }
                    },
                    error: function() {
                        $('.loading').hide();
                        $('.error-message').text('Error verifying student ID. Please try again.');
                    }
                });
            }
        });
    });
</script>
</body>
</html>