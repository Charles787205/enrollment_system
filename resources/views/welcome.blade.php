<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>University M.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar {
            background-color: #d32f2f;
            padding: 1.5rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo a {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            text-decoration: underline;
            opacity: 0.9;
        }

        .navbar a.btn {
            background-color: #ffeb3b;
            color: #d32f2f;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .navbar a.btn:hover {
            background-color: #fdd835;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .hero {
            background-image: url('/img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 104vh;
            width: 100%;
            color: white;
            padding: 6rem 2rem;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: -1.5rem;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .hero h1,
        .hero p,
        .hero .btn {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .hero .btn {
            background-color: #ffeb3b;
            color: #d32f2f;
            padding: 1rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero .btn:hover {
            background-color: #fdd835;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content {
            padding: 4rem 2rem;
            text-align: center;
            background: #fff;
            position: relative;
            z-index: 2;
            scroll-margin-top: 80px;

        }

        .content h2 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 2.5rem;
        }

        .content p {
            margin-bottom: 2rem;
            color: #666;
            font-size: 1.1rem;
        }

        .content .strands {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-top: 3rem;
        }

        .content .strand {
            background-color: #ffeb3b;
            color: #d32f2f;
            padding: 2rem;
            border-radius: 8px;
            width: 200px;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content .strand:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #d32f2f;
            color: white;
            text-align: center;
            padding: 1.5rem;
            position: relative;
            width: 100%;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .navbar .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .content .strand {
                width: 150px;
                padding: 1.5rem;
            }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            position: relative;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1.5rem;
            background-color: #d32f2f;
            color: white;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .close {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .close:hover {
            opacity: 0.7;
        }

        .modal-body {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .modal-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            background-color: #f8f9fa;
            color: #333;
            padding: 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .modal-btn:hover {
            background-color: #ffeb3b;
            color: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-btn i {
            font-size: 1.5rem;
            color: #d32f2f;
        }


        .content .strand {
            background-color: #fff;
            color: #d32f2f;
            padding: 1rem;
            border-radius: 8px;
            width: 150px;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content .strand img {
            width: 100px;
            height: 100px;
            margin-bottom: 1rem;
        }

        .content .strand:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        #featuresModal .modal-content {
            max-width: 900px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
        }

        .feature-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .feature-card i {
            font-size: 2.5rem;
            color: #d32f2f;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #333;
            margin-bottom: 0.75rem;
            font-size: 1.25rem;
        }

        .feature-card p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
        }

        #featuresModal .modal-content {
            max-width: 800px;
        }

        html {
            scroll-behavior: smooth;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .blog-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .blog-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .blog-card:hover .blog-image img {
            transform: scale(1.1);
        }

        .blog-content {
            padding: 1.5rem;
        }

        .blog-content h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .blog-date {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .blog-date i {
            color: #d32f2f;
        }

        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #d32f2f;
            text-decoration: none;
            font-weight: 500;
            margin-top: 1rem;
            transition: gap 0.3s ease;
        }

        .read-more:hover {
            gap: 0.75rem;
        }

        .pages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
        }

        .page-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .page-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .page-card i {
            font-size: 2.5rem;
            color: #d32f2f;
        }

        .page-card h3 {
            color: #333;
            margin: 0;
            font-size: 1.25rem;
        }

        .page-card p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.4;
        }

        #pagesModal .modal-content {
            max-width: 900px;
        }

        .help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .help-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
        }

        .help-card i {
            font-size: 2.5rem;
            color: #d32f2f;
            margin-bottom: 1rem;
        }

        .help-card h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
        }

        .faq-list details {
            text-align: left;
            margin-bottom: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .faq-list summary {
            font-weight: 500;
            color: #333;
            margin: -1rem;
            padding: 1rem;
            outline: none;
        }

        .faq-list details p {
            margin-top: 1rem;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .contact-info {
            text-align: left;
        }

        .contact-info p {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: #666;
        }

        .contact-info i {
            font-size: 1.2rem;
            margin: 0;
        }

        #helpModal .modal-content {
            max-width: 800px;
        }

        .admin-btn {
            background-color: #333;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-btn:hover {
            background-color: #444;
            text-decoration: none;
        }

        .admin-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .admin-form .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .admin-form label {
            color: #333;
            font-weight: 500;
        }

        .admin-form input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .admin-login-btn {
            background-color: #d32f2f;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .admin-login-btn:hover {
            background-color: #b71c1c;
        }


    </style>
</head>

<body class="antialiased">
    <div class="navbar">
        <div class="logo">
            <a href="#">UNIVERSITY M.</a>
        </div>
        <div class="nav-links">
            <a href="#" id="featuresBtn">Features</a>
            <a href="#strands-section" id="strandsBtn">Strands</a>
            <a href="#blog-section" id="blogBtn">Blog</a>
            <a href="#" id="pagesBtn">Pages</a>
            <a href="#" id="helpBtn">Help</a>
            <a href="#" id="adminBtn" class="admin-btn">Admin <i class="fas fa-user-shield"></i></a>

        </div>
    </div>

    <div class="hero">
        <h1>ABOUT UM</h1>
        <p>The University of Mindanao is the largest private, non-sectarian university in Mindanao located in Davao City
            on the Southern Philippine island.</p>
        <button type="button" class="btn">ENROLL NOW</button>
    </div>

    <div class="content">
        <h2 id="strands-section">Early Registration for Senior High School</h2>
        <p>Interested applicants may join our virtual session on April 21, 2025</p>

        <div class="strands mt-4">
            <div class="strand">
                <img src="{{ asset('img/logo.png') }}">
                <p>STEM</p>
            </div>
            <div class="strand">
                <img src="{{ asset('img/logo.png') }}" alt="ABM">
                <p>ABM</p>
            </div>
        </div>
    </div>

    <div class="content" id="blog-section">
        <h2>Latest Blog Posts</h2>
        <p>Stay updated with our university news and events</p>

        <div class="blog-grid">
            <div class="blog-card">
                <div class="blog-image">
                    <img src="{{ asset('img/blog1.jpg') }}" alt="Blog Post 1">
                </div>
                <div class="blog-content">
                    <h3>Campus Life at UM</h3>
                    <p class="blog-date"><i class="far fa-calendar-alt"></i> March 20, 2025</p>
                    <p>Experience the vibrant student life and diverse community at University of Mindanao.</p>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="blog-card">
                <div class="blog-image">
                    <img src="{{ asset('img/blog2.jpg') }}" alt="Blog Post 2">
                </div>
                <div class="blog-content">
                    <h3>Academic Excellence</h3>
                    <p class="blog-date"><i class="far fa-calendar-alt"></i> March 18, 2025</p>
                    <p>Discover our commitment to academic excellence and student success.</p>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="blog-card">
                <div class="blog-image">
                    <img src="{{ asset('img/blog3.jpg') }}" alt="Blog Post 3">
                </div>
                <div class="blog-content">
                    <h3>Research Innovations</h3>
                    <p class="blog-date"><i class="far fa-calendar-alt"></i> March 15, 2025</p>
                    <p>Learn about our latest research breakthroughs and innovations.</p>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        Join University of Mindanao
    </div>

    <!-- Enroll Modal -->
    <div class="modal" id="enrollModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Choose Enrollment Type</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <a href="{{ url('/transferee') }}" class="modal-btn">
                    <i class="fas fa-exchange-alt"></i>
                    Transferee Student
                </a>
                <a href="{{ url('/old-student') }}" class="modal-btn">
                    <i class="fas fa-user-graduate"></i>
                    Old Student
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('enrollModal');
            const enrollBtn = document.querySelector('.hero .btn');
            const closeBtn = document.querySelector('.modal .close');

            enrollBtn.addEventListener('click', function () {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeBtn.addEventListener('click', function () {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            });

            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            const featuresModal = document.getElementById('featuresModal');
            const featuresBtn = document.getElementById('featuresBtn');
            const closeFeaturesBtn = document.getElementById('closeFeaturesBtn');

            featuresBtn.addEventListener('click', function (e) {
                e.preventDefault();
                featuresModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeFeaturesBtn.addEventListener('click', function () {
                featuresModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            featuresModal.addEventListener('click', function (e) {
                if (e.target === featuresModal) {
                    featuresModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            const strandsBtn = document.getElementById('strandsBtn');

            strandsBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const strandsSection = document.getElementById('strands-section');
                strandsSection.scrollIntoView({ behavior: 'smooth' });
            });

            const blogBtn = document.getElementById('blogBtn');

            blogBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const blogSection = document.getElementById('blog-section');
                blogSection.scrollIntoView({ behavior: 'smooth' });
            });
            // Pages Modal
            const pagesModal = document.getElementById('pagesModal');
            const pagesBtn = document.getElementById('pagesBtn');
            const closePagesBtn = document.getElementById('closePagesBtn');

            pagesBtn.addEventListener('click', function (e) {
                e.preventDefault();
                pagesModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closePagesBtn.addEventListener('click', function () {
                pagesModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            pagesModal.addEventListener('click', function (e) {
                if (e.target === pagesModal) {
                    pagesModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            // Help Modal
            const helpModal = document.getElementById('helpModal');
            const helpBtn = document.getElementById('helpBtn');
            const closeHelpBtn = document.getElementById('closeHelpBtn');

            helpBtn.addEventListener('click', function (e) {
                e.preventDefault();
                helpModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeHelpBtn.addEventListener('click', function () {
                helpModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            helpModal.addEventListener('click', function (e) {
                if (e.target === helpModal) {
                    helpModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            // Add this inside your existing DOMContentLoaded event listener
            const adminModal = document.getElementById('adminModal');
            const adminBtn = document.getElementById('adminBtn');
            const closeAdminBtn = document.getElementById('closeAdminBtn');

            adminBtn.addEventListener('click', function (e) {
                e.preventDefault();
                adminModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeAdminBtn.addEventListener('click', function () {
                adminModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            adminModal.addEventListener('click', function (e) {
                if (e.target === adminModal) {
                    adminModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            const adminRegisterModal = document.getElementById('adminRegisterModal');
            const adminRegisterBtn = document.querySelector('.toggle-link[href="#adminRegisterModal"]');
            const closeAdminRegisterBtn = document.getElementById('closeAdminRegisterBtn');
            const backToLoginLink = document.getElementById('backToLogin');

            adminRegisterBtn.addEventListener('click', function (e) {
                e.preventDefault();
                adminRegisterModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeAdminRegisterBtn.addEventListener('click', function () {
                adminRegisterModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            backToLoginLink.addEventListener('click', function (e) {
                e.preventDefault();
                adminRegisterModal.classList.remove('show');
                adminModal.classList.add('show');
            });

            adminRegisterModal.addEventListener('click', function (e) {
                if (e.target === adminRegisterModal) {
                    adminRegisterModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>

    <div class="modal" id="featuresModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>University Features</h2>
                <span class="close" id="closeFeaturesBtn">&times;</span>
            </div>
            <div class="modal-body">
                <div class="features-grid">
                    <div class="feature-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Quality Education</h3>
                        <p>World-class education with experienced faculty members</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-flask"></i>
                        <h3>Modern Facilities</h3>
                        <p>State-of-the-art laboratories and learning spaces</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-users"></i>
                        <h3>Student Life</h3>
                        <p>Rich campus life with various student organizations</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-medal"></i>
                        <h3>Excellence</h3>
                        <p>Recognized for academic and research excellence</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages Modal -->
    <div class="modal" id="pagesModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>University Pages</h2>
                <span class="close" id="closePagesBtn">&times;</span>
            </div>
            <div class="modal-body">
                <div class="pages-grid">
                    <a href="#" class="page-card">
                        <i class="fas fa-university"></i>
                        <h3>About Us</h3>
                        <p>Learn about our history and mission</p>
                    </a>
                    <a href="#" class="page-card">
                        <i class="fas fa-book"></i>
                        <h3>Programs</h3>
                        <p>Explore our academic offerings</p>
                    </a>
                    <a href="#" class="page-card">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Events</h3>
                        <p>Upcoming university events</p>
                    </a>
                    <a href="#" class="page-card">
                        <i class="fas fa-handshake"></i>
                        <h3>Admissions</h3>
                        <p>Join our academic community</p>
                    </a>
                    <a href="#" class="page-card">
                        <i class="fas fa-users"></i>
                        <h3>Student Life</h3>
                        <p>Campus activities and organizations</p>
                    </a>
                    <a href="#" class="page-card">
                        <i class="fas fa-phone"></i>
                        <h3>Contact</h3>
                        <p>Get in touch with us</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Help Modal -->
    <div class="modal" id="helpModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Help Center</h2>
                <span class="close" id="closeHelpBtn">&times;</span>
            </div>
            <div class="modal-body">
                <div class="help-grid">
                    <div class="help-card">
                        <i class="fas fa-question-circle"></i>
                        <h3>FAQs</h3>
                        <div class="faq-list">
                            <details>
                                <summary>How do I enroll?</summary>
                                <p>Click the "ENROLL NOW" button and choose your student type (New, Transferee, or Old
                                    Student).</p>
                            </details>
                            <details>
                                <summary>What documents do I need?</summary>
                                <p>Requirements include transcript, good moral character certificate, and birth
                                    certificate.</p>
                            </details>
                            <details>
                                <summary>What are the available strands?</summary>
                                <p>We offer STEM and ABM strands for Senior High School.</p>
                            </details>
                        </div>
                    </div>
                    <div class="help-card">
                        <i class="fas fa-headset"></i>
                        <h3>Contact Support</h3>
                        <div class="contact-info">
                            <p><i class="fas fa-phone"></i> (082) 123-4567</p>
                            <p><i class="fas fa-envelope"></i> support@um.edu.ph</p>
                            <p><i class="fas fa-clock"></i> Mon-Fri: 8:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Login Modal -->
    <div class="modal" id="adminModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Admin Login</h2>
                <span class="close" id="closeAdminBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.login.post') }}" method="POST" class="admin-form">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit" class="admin-login-btn">Login</button>
                </form>
                <a href="#adminRegisterModal" class="toggle-link">
   
                <p id="welcomeMessage" style="display: none;">Welcome, <span id="adminName"></span>!</p>
            </div>
        </div>
    </div>

    </body>
</html>