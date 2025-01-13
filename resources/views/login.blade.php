<?php
session_start();

$gambar = [asset('images/pict-car1.jpg'), asset('images/pict-car2.jpg'), asset('images/pict-car3.jpg'), asset('images/pict-car4.jpeg'), asset('images/pict-car5.jpg')];

$gambar2 = [asset('images/pict-car-hotelist1.jpg'), asset('images/pict-car-hotelist2.jpg'), asset('images/pict-car-hotelist3.jpeg'), asset('images/pict-car-hotelist4.jpeg'), asset('images/pict-car-hotelist5.jpg'), asset('images/pict-car-hotelist6.jpg')];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userStyle/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/poppins.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home Page</title>
</head>

<body>
    <div style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('AsetGambarRoom/c3.png') }}');
        background-size: cover;
        background-position: center;
        filter: blur(8px);
        z-index: -1;">
    </div>

    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: white; border-bottom:solid gray thin">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <strong>Hotel</strong><span class="text-appbar-second-color"><strong>OlangKaya</strong></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('facility') }}">Facility</a>
                    </li>
                    <?php if (isset($_SESSION["user"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('choose_booking') }}">Booking</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('login') }}">Booking</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <button type="button" class="btn btn-primary" style="background-color: #824D69; border: none;">
                    <a href="{{ route('register') }}" style="text-decoration: none; color: white;">
                        <strong>Register</strong>
                    </a>
                </button>
                <button type="button" class="btn btn-primary" style="background-color: #824D69; border: none;">
                    <a href="{{ route('login') }} " style="text-decoration: none; color: white;">
                        <strong>Login</strong>
                    </a>
                </button>
            </div>
        </div>
    </nav>

    <form action="{{ route('user.login') }}" method="POST" id="formAuth" enctype="multipart/form-data">
        @csrf
        <h1>Login</h1>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" placeholder="Email">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="exampleFormControlInput1" class="form-label">Password</label>
            <div class="mata position-relative">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                <i class="fa-solid fa-eye position-absolute" id="visibilityBtn" style="cursor: pointer;"></i>
            </div> 
        </div>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-secondary" type="button"
                    style="background-color:#4a2d56">Login</button>
                <input type="hidden" name="mencoba_login" value="1">
            </div>
        </div>

        <div class="mb-4 text-center">
            <p>Don't have an account? <a href="{{ route('register') }}" style="color:#824D69; font-weight: bold">Register here</a></p>
        </div>

        <div class="mb-4 text-center">
            <p>By logging in, I agree to Olangkaya's 
                <a href="{{ route('terms') }}" style="color: #824D69;">Terms of Use</a> and 
                <a href="{{ route('privacy') }}" style="color: #824D69;">Privacy Policy</a>.
            </p>
        </div>
    </form>

    <footer>
        <div class="footer-container">
            <div class="footer-content-container">
                <h5 style="color: white;">
                    Hotel
                    <span class="footer-title-hotelname">OlangKaya</span>
                </h5>
                <p style="color: white;">497 Evergreen Rd. Roseville, CA 95673</p>
                <p style="color: white;">+44 345 678 903</p>
                <p style="color: white;">hotelolangkaya@gmail.com</p>
            </div>
            <div class="footer-content-container">
                <ul>
                    <li>About Us</li>
                    <li>Contact</li>
                    <li><a href="{{ route('terms') }}" style="color: white; text-decoration: none;">Terms & Condition</a></li>
                </ul>
            </div>
            <div class="footer-content-container">
                <ul>
                    <li>
                        <img src="{{ asset('images/facebook-icon.svg') }}" alt="">
                        Facebook
                    </li>
                    <li>
                        <img src="{{ asset('images/twitter-icon.svg') }}" alt="">
                        Twitter
                    </li>
                    <li>
                        <img src="{{ asset('images/instagram-icon.svg') }}" alt="">
                        Instagram
                    </li>
                </ul>
            </div>
            <div class="footer-content-container">
                <h6 style="color: white;">Subscribe to our newsletter</h6>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email Address"
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">OK</button>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/swiper_script.min.js') }} "></script>
    <script>
        const visibilityBtn = document.getElementById("visibilityBtn");
        visibilityBtn.addEventListener("click", toggleVisibility);

        function toggleVisibility() {
            const passwordInput = document.getElementById("password");

            if (passwordInput.type === "text") {
                passwordInput.type = "password";
                visibilityBtn.classList.remove("fa-eye");
                visibilityBtn.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "text";
                visibilityBtn.classList.remove("fa-eye-slash");
                visibilityBtn.classList.add("fa-eye");
            }
        }

        const visibilityBtn2 = document.getElementById("visibilityBtn2");

        visibilityBtn2.addEventListener("click", toggleVisibility2);

        function toggleVisibility2() {
            const passwordInput2 = document.getElementById("password2");

            if (passwordInput2.type === "text") {
                passwordInput2.type = "password";
                visibilityBtn2.classList.remove("fa-eye");
                visibilityBtn2.classList.add("fa-eye-slash");
            } else {
                passwordInput2.type = "text";
                visibilityBtn2.classList.remove("fa-eye-slash");
                visibilityBtn2.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>