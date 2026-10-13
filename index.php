<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Digital Library Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: 'Segoe UI', sans-serif;
}

/* Navbar */

.navbar{
    background: rgba(0,0,0,0.85);
}

.navbar-brand{
    font-size:1.5rem;
    font-weight:bold;
}

.nav-link{
    color:white !important;
    margin-left:15px;
}

.nav-link:hover{
    color:#ffc107 !important;
}

/* Hero Section */

.hero{
    height:100vh;
    background:
    linear-gradient(rgba(0,0,0,0.6),
    rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da');
    
    background-size:cover;
    background-position:center;

    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;

    color:white;
}

.hero h1{
    font-size:4rem;
    font-weight:bold;
}

.hero p{
    font-size:1.3rem;
    margin-top:15px;
}

.hero-btn{
    margin-top:20px;
}

/* About Section */

.about{
    padding:80px 0;
}

.about img{
    width:100%;
    border-radius:15px;
}

/* Feature Cards */

.features{
    padding:80px 0;
    background:#f8f9fa;
}

.feature-card{
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.feature-card:hover{
    transform:translateY(-10px);
}

.feature-card i{
    font-size:45px;
    color:#0d6efd;
    margin-bottom:15px;
}

.section-title{
    text-align:center;
    margin-bottom:50px;
}

</style>
</head>
<body>

<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
<div class="container">

<a class="navbar-brand" href="#">
<i class="fas fa-book-open"></i>
Digital Library
</a>

<button class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse"
id="navbarNav">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="#">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#about">About</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#features">Features</a>
</li>

<li class="nav-item">
<a class="nav-link btn btn-warning text-dark px-3"
href="login.php">
Login
</a>
</li>

<li class="nav-item ms-2">
<a class="nav-link btn btn-success px-3"
href="register.php">
Register
</a>
</li>

</ul>

</div>

</div>
</nav>

<!-- Hero Section -->

<section class="hero">

<div class="container">

<h1>Welcome To Digital Library</h1>

<p>
Manage Books, Students, Issue & Return
Books Easily With Our Smart Library System
</p>

<div class="hero-btn">

<a href="register.php"
class="btn btn-warning btn-lg me-2">
Get Started
</a>

<a href="login.php"
class="btn btn-outline-light btn-lg">
Login
</a>

</div>

</div>

</section>

<!-- About Section -->

<section class="about" id="about">

<div class="container">

<div class="row align-items-center">

<div class="col-md-6">

<img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66"
alt="Library">

</div>

<div class="col-md-6">

<h2>About Our Library</h2>

<p class="mt-3">

The Digital Library Management System
helps administrators manage books,
students, issue records and returns
efficiently.

This system reduces manual work
and provides a modern solution
for library operations.

</p>

<a href="register.php"
class="btn btn-primary">
Join Now
</a>

</div>

</div>

</div>

</section>

<!-- Features Section -->

<section class="features" id="features">

<div class="container">

<div class="section-title">

<h2>Our Features</h2>

<p>Powerful tools for modern libraries</p>

</div>

<div class="row g-4">

<div class="col-md-4">

<div class="feature-card text-center">

<i class="fas fa-book"></i>

<h4>Book Management</h4>

<p>
Add, Edit, Delete and Manage
Books Easily.
</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-card text-center">

<i class="fas fa-user-graduate"></i>

<h4>Student Management</h4>

<p>
Manage Student Details
And Track Activities.
</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-card text-center">

<i class="fas fa-right-left"></i>

<h4>Issue & Return</h4>

<p>
Track Issued Books
And Returns Efficiently.
</p>

</div>

</div>

<!-- Call To Action -->

<section class="py-5 text-center">

    <div class="container">

        <h2 class="mb-3">
            Start Managing Your Library Today
        </h2>

        <p class="mb-4">
            Join our Digital Library Management System
            and simplify library operations.
        </p>

        <a href="register.php"
           class="btn btn-success btn-lg me-2">
            Register Now
        </a>

        <a href="login.php"
           class="btn btn-outline-primary btn-lg">
            Login
        </a>

    </div>

</section>

<!-- Footer -->

<footer class="bg-dark text-white pt-4 pb-3">

    <div class="container">

        <div class="row">

            <div class="col-md-4 mb-3">

                <h4>
                    <i class="fas fa-book-open"></i>
                    Digital Library
                </h4>

                <p>
                    A modern web-based Library
                    Management System developed using
                    HTML, CSS, Bootstrap,
                    JavaScript, PHP and MySQL.
                </p>

            </div>

            <div class="col-md-4 mb-3">

                <h5>Quick Links</h5>

                <ul class="list-unstyled">

                    <li>
                        <a href="#"
                           class="text-white text-decoration-none">
                           Home
                        </a>
                    </li>

                    <li>
                        <a href="#about"
                           class="text-white text-decoration-none">
                           About
                        </a>
                    </li>

                    <li>
                        <a href="#features"
                           class="text-white text-decoration-none">
                           Features
                        </a>
                    </li>

                </ul>

            </div>

            <div class="col-md-4 mb-3">

                <h5>Contact</h5>

                <p>
                    <i class="fas fa-envelope"></i>
                    info@digitallibrary.com
                </p>

                <p>
                    <i class="fas fa-phone"></i>
                    +91 9876543210
                </p>

            </div>

        </div>

        <hr>

        <div class="text-center">

            <p class="mb-0">
                © 2026 Digital Library Management System.
                All Rights Reserved.
            </p>

        </div>

    </div>

</footer>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scroll Animation -->

<script>

const cards = document.querySelectorAll('.feature-card');

window.addEventListener('scroll', () => {

    cards.forEach(card => {

        const cardTop = card.getBoundingClientRect().top;

        if(cardTop < window.innerHeight - 100)
        {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }

    });

});

cards.forEach(card => {

    card.style.opacity = "0";
    card.style.transform = "translateY(50px)";
    card.style.transition = "all 0.8s ease";

});

</script>

</section>
</body>
</html>