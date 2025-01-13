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
    <title>Edit User</title>
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
                            <h2>Edit User</h2>
                            <hr>

                            <form method="POST" action="{{ route('Admin.users.update', $user->id_user) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            
                                <div class="mb-3">
                                    <label for="first_name" class="form-label"><strong>First Name</strong></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="mb-3">
                                    <label for="last_name" class="form-label"><strong>Last Name</strong></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="mb-3">
                                    <label for="email" class="form-label"><strong>Email</strong></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="mb-3">
                                    <label for="telepon" class="form-label"><strong>Phone Number</strong></label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" 
                                           value="{{ old('telepon', $user->telepon) }}" required>
                                    @error('telepon')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="user_picture" class="form-label"><strong>Profile Picture</strong></label>
                                    <input type="file" class="form-control" id="user_picture" name="user_picture" accept="image/*">
                                    @error('user_picture')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" style="background-color: #824D69; border: none;">
                                        <a href="{{ route('admin_user_management') }}" style="text-decoration: none; color: white;">
                                            <strong>Save Changes</strong>
                                        </a>
                                    </button>
                                </div>
                            </form> 

                            
                        </div>
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