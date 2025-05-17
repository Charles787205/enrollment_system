<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Student Registration - University M.</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 1rem;
        }

        .requirements {
            background: #fff8e1;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            color: #d32f2f;
        }

        .requirements ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-section h2 {
            color: #d32f2f;
            margin-bottom: 1rem;
            border-bottom: 2px solid #d32f2f;
            display: inline-block;
            padding-bottom: 0.25rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 0.75rem;
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
            font-weight: bold;
            transition: background 0.3s;
            float: right;
        }

        .btn:hover {
            background: #b71c1c;
        }

        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #d32f2f;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
            background: #f8f9fa;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .file-upload:hover {
            border-color: #d32f2f;
            background: #fff;
        }

        .file-upload input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 2rem;
            color: #d32f2f;
            margin-bottom: 1rem;
        }

        .file-upload-text {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .file-upload-info {
            color: #999;
            font-size: 0.875rem;
        }

        .selected-file {
            background: #e8f5e9;
            padding: 0.5rem;
            border-radius: 4px;
            margin-top: 0.5rem;
            display: none;
        }

        .selected-file i {
            color: #4caf50;
            margin-right: 0.5rem;
        }

        .error-message {
            color: #d32f2f;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 1rem;
            border-radius: 4px;
            margin-top: 1rem;
            display: none;
            align-items: center;
            gap: 0.5rem;
        }

        .success-message i {
            color: #2e7d32;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Old Student Registration</h1>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <!-- Modal -->
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>{{ session('success') }}</h2>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById("successModal");
                var span = document.getElementsByClassName("close")[0];
                modal.style.display = "block";

                // Close the modal when clicking the X
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // Close the modal when clicking outside
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            });
        </script>

        <style>
            /* Modal background */
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                padding-top: 100px;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
                animation: fadeIn 0.3s ease-out;
            }

            /* Modal content box */
            .modal-content {
                background-color: #fff;
                margin: auto;
                padding: 30px;
                border: none;
                width: 400px;
                text-align: center;
                border-radius: 12px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                animation: slideIn 0.4s ease-out;
                position: relative;
                /* Allow positioning the close button */
            }

            /* Close button */
            .close {
                color: #aaa;
                font-size: 28px;
                font-weight: bold;
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
            }

            .close:hover,
            .close:focus {
                color: #333;
                text-decoration: none;
            }

            /* Success message styling */
            .modal-content h2 {
                font-size: 20px;
                color: #27ae60;
                /* Green for success */
                font-weight: bold;
                margin: 10px 0;
                text-transform: uppercase;
            }

            /* Animation for modal fade-in */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            /* Animation for modal slide-in */
            @keyframes slideIn {
                from {
                    transform: translateY(-30px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>
        @endif


        <!-- Registration Form -->
        <form action="{{ route('old-student.register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="student_id" value="{{ $student->student_id }}">

            <div class="form-section">
                <h2>Personal Information</h2>
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" id="student_id" name="student_id" value="{{ $student->student_id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ $student->first_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" value="{{ $student->middle_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ $student->last_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $student->email }}" readonly>
                </div>
            </div>

            <div class="form-section">
                <h2>Academic Details</h2>
                <div class="form-group">
                    <label for="strand">Strand:</label>
                    <input type="text" id="strand" name="strand" value="{{ $student->strand }}" readonly>
                </div>
                <div class="form-group">
                    <label for="year_level">Year Level</label>
                    <input type="text" id="year_level" name="year_level" value="{{ $student->year_level }}" readonly>
                </div>
            </div>

            <div class="form-section">
                <h3>Required Documents</h3>
                <div class="form-group">
                    <label>Clearance from previous semester<span class="required">*</span></label>
                    <input type="file" id="clearance_file" name="clearance_file" accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="file-help">Accepted formats: PDF, JPG, PNG (Max: 2MB)</small>
                    <div id="clearance_file_preview" class="selected-file"></div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn">Submit Application</button>
            </div>
            <a href="/" class="back-link">← Back to Home</a>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[type="file"]').forEach(function (input) {
            input.addEventListener('change', function (e) {
                const file = this.files[0];
                if (!file) return;

                // Check file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = ''; // Clear the input
                    return;
                }

                // Create a preview box
                const previewId = this.name + '_preview'; // Based on input "name"
                let preview = document.getElementById(previewId);
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = previewId;
                    preview.className = 'selected-file';
                    this.parentNode.appendChild(preview); // Insert preview after input
                }
                preview.innerHTML = ''; // Clear old preview

                // Show file preview
                if (file.type.startsWith('image/')) {
                    // If image (jpg, jpeg, png), show thumbnail
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxWidth = '200px';
                    img.style.marginTop = '10px';
                    preview.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    // If PDF, show file icon and name
                    preview.innerHTML = `
                <i class="fas fa-file-pdf"></i>
                <span>${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)</span>
            `;
                } else {
                    // Unsupported file type
                    preview.innerHTML = `<span>Unsupported file type</span>`;
                }

                preview.style.display = 'block';
            });
        });
    </script>

    <style>
        .selected-file {
            margin-top: 10px;
            padding: 5px;
            border: 1px dashed #ccc;
            background-color: #f9f9f9;
            display: inline-block;
        }

        .selected-file img {
            max-width: 100%;
            height: auto;
        }

        .selected-file i {
            font-size: 24px;
            color: #e74c3c;
            margin-right: 5px;
        }
    </style>
</body>

</html>