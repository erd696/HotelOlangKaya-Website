<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/poppins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userStyle/profileStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Profile</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin_home') }}">
                <strong>Hotel</strong><span class="text-appbar-second-color"><strong>OlangKaya</strong></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('Admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('admin_room_master') }}">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('admin_hall_package_master') }}">Hall Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('Admin.users') }}">User Management</a>
                    </li>
                </ul>
            </div>
                @if(auth('admin')->check())
                    <div>
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: white; color: black; border: none;">
                                <img src="{{ asset('AsetGambar/'.auth('admin')->user()->admin_picture) }}" alt="pict" class="profile-img-nav">
                                <span><strong>{{ auth('admin')->user()->admin_name }}</strong></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @elseif(auth()->check())
                    <div>
                        <p>Welcome, {{ auth()->user()->name }}</p>
                    </div>
                @else
                    <button type="button" class="btn btn-primary me-2" style="background-color: #824D69; border: none;">
                        <a href="{{ route('register') }}" style="text-decoration: none; color: white;">
                            <strong>Register</strong>
                        </a>
                    </button>
                    <button type="button" class="btn btn-primary" style="background-color: #824D69; border: none;">
                        <a href="{{ route('login') }}" style="text-decoration: none; color: white; border-bottom: 2px solid white;">
                            <strong>Login</strong>
                        </a>
                    </button>
                @endif
        </div>
    </nav>
    <main>
        <br><br>
        <div style="background-color: white;">
            <div class="container">
                <div class="shadow p-4" style="max-width: 1000px; margin: auto;">
                    <div class="row mb-3">
                        <div class="col-md-10 mx-auto">
                            <div class="mb-4">
                                <a href="{{ route('Admin.users') }}" class="text-muted" style="font-size: 1.2rem;">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <h2>Create Admin</h2>
                            <hr>
                            <form method="POST" action="{{ route('Admin.users.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="admin_name" class="form-label"><strong>Admin Name</strong></label>
                                    <input type="text" id="admin_name" name="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="admin_email" class="form-label"><strong>Email</strong></label>
                                    <input type="email" id="admin_email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="admin_password" class="form-label"><strong>Password</strong></label>
                                    <input type="password" id="admin_password" name="admin_password" class="form-control" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="admin_telp" class="form-label"><strong>Phone</strong></label>
                                    <input type="text" id="admin_telp" name="admin_telp" class="form-control" value="{{ old('admin_telp') }}" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="admin_picture" class="form-label"><strong>Profile Picture</strong></label>
                                    <input type="file" id="admin_picture" name="admin_picture" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Create Admin</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </main>      
</body>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('js/swiper_script.min.js') }} "></script>
</html>