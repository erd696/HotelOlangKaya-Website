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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Profile</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: white; border-bottom: solid gray thin;">
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
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('choose_booking') }}">Booking</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('login') }}">Booking</a>
                        </li>
                    @endauth
                </ul>
            </div>

            <div class="d-flex">
                @auth
                    <div>
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="background-color: white; color: black; border: none;">
                                <img src="{{ asset('AsetGambar/' . auth()->user()->user_picture) }}" alt="Profile"
                                    class="profile-img-nav">
                                <span><strong>{{ auth()->user()->first_name }}
                                        {{ auth()->user()->last_name }}</strong></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li>
                                    <form action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <button type="button" class="btn btn-primary me-2" style="background-color: #824D69; border: none;">
                        <a href="{{ route('register') }}" style="text-decoration: none; color: white;">
                            <strong>Register</strong>
                        </a>
                    </button>
                    <button type="button" class="btn btn-primary" style="background-color: #824D69; border: none;">
                        <a href="{{ route('login') }}"
                            style="text-decoration: none; color: white; border-bottom: 2px solid white;">
                            <strong>Login</strong>
                        </a>
                    </button>
                @endauth
            </div>
        </div>
    </nav>
    <main>
        <div style="background-color: white;">
            <div class="container">
                <div class="shadow p-4" style="max-width: 1000px; margin: auto;">
                    <div style="background-color: white;">
                        <form action="{{ route('user.update', auth()->user()->id_user) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="container profile-section">
                                <div class="position-relative d-inline-block">
                                    <img id="profilePreview"
                                        src="{{ asset('AsetGambar/' . auth()->user()->user_picture) }}"
                                        alt="Profile Picture" class="profile-img">
                                    <input type="file" id="profilePictureInput" name="user_picture" class="d-none"
                                        onchange="previewImage()">
                                    <div class="edit-icon"
                                        onclick="document.getElementById('profilePictureInput').click();">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                                <div class="profile-name">{{ auth()->user()->first_name }}
                                    {{ auth()->user()->last_name }}</div>
                            </div>
                            <br><br>
                            <div class="container">
                                <div class="row mb-3">
                                    <div class="col-md-10 mx-auto">
                                        <h2>Edit Profile</h2>
                                        <hr>
                                        <div class="form-group">
                                            <label for="firstName" class="form-label"><strong>First
                                                    Name</strong></label>
                                            <div class="input-group input-group-lg">
                                                <input type="text" id="firstName" name="first_name"
                                                    class="form-control" aria-label="First Name"
                                                    aria-describedby="inputGroup-sizing-lg"
                                                    value="{{ old('first_name', auth()->user()->first_name) }}">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="lastName" class="form-label"><strong>Last
                                                    Name</strong></label>
                                            <div class="input-group input-group-lg">
                                                <input type="text" id="lastName" name="last_name"
                                                    class="form-control" aria-label="Last Name"
                                                    aria-describedby="inputGroup-sizing-lg"
                                                    value="{{ old('last_name', auth()->user()->last_name) }}">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="email" class="form-label"><strong>Email</strong></label>
                                            <div class="input-group input-group-lg">
                                                <input type="email" id="email" name="email"
                                                    class="form-control" aria-label="Email"
                                                    aria-describedby="inputGroup-sizing-lg"
                                                    value="{{ old('email', auth()->user()->email) }}">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="notel" class="form-label"><strong>Nomor
                                                    Telepon</strong></label>
                                            <div class="input-group input-group-lg">
                                                <input type="text" id="notel" name="telepon"
                                                    class="form-control" aria-label="Nomor Telepon"
                                                    aria-describedby="inputGroup-sizing-lg"
                                                    value="{{ old('telepon', auth()->user()->telepon) }}">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row mb-3">
                                            <div class="col-md-16 mx-auto text-end">
                                                <button type="submit" class="btn btn-primary"
                                                    style="background-color: #824D69; border: none;">
                                                    <strong>Save Changes</strong>
                                                </button>
                                            </div>
                                        </div>
                        </form>
                    </div>
                </div>

                <form action="{{ route('user.updatePassword', auth()->user()->id_user) }}" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-10 mx-auto">
                                @csrf
                                @method('PUT')
                                <h2>Change Password</h2>
                                <hr>
                                <div class="form-group">
                                    <label for="currPass" class="form-label"><strong>Current Password</strong></label>
                                    <div class="input-group input-group-lg">
                                        <input type="password" id="currPass" name="current_password" class="form-control"
                                            aria-label="Current Password" aria-describedby="inputGroup-sizing-lg">
                                    </div>
                                    @if ($errors->has('current_password'))
                                        <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                    @endif
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="newPass" class="form-label"><strong>New Password</strong></label>
                                    <div class="input-group input-group-lg">
                                        <input type="password" id="newPass" name="new_password" class="form-control"
                                            aria-label="New Password" aria-describedby="inputGroup-sizing-lg">
                                    </div>
                                    @if ($errors->has('new_password'))
                                        <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                    @endif
                                </div>
                                <br>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-10 mx-auto text-end">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #824D69; border: none;">
                                <strong>Change Password</strong>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>

        <br><br><br>
        <div style="background-color: #2A114B;">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-10 mx-auto">
                        <br><br>
                        <h2 style="color: #DFB6B2">On Going Transaction</h2>
                        <hr style="background-color: #DFB6B2; height: 3px; border: none;">

                        <?php use Illuminate\Support\Facades\Log; ?>

                        @foreach ($unpaidBookings as $booking)
                            @if ($booking->id_hall_package && $booking->id_hall_package != null)
                                <div class="card mb-3 mx-auto" style="max-width: 85%; margin-top: 20px">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 250px">
                                            <img src="{{ asset('AsetGambar/' . $booking->package_picture) }}"
                                                class="img-fluid rounded-start" alt="pict"
                                                style="width: 300px; height: 250px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-8" style="margin-left: 0px;">
                                            <div class="card-body">
                                                <h2 class="card-title"><strong>{{ $booking->package_name }}</strong></h2>
                                                <p style="margin-bottom:0;">Booking Date:
                                                    <strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }} -
                                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</strong>
                                                </p>
                                                <p style="margin-bottom: 0;">Attendee Number:
                                                    <strong>{{ $booking->attendee_number }}</strong>
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-end flex-column" style="position: absolute; bottom: 10px; right: 10px;">
                                                <p style="margin-bottom: 0;">Total Price:
                                                    <strong>IDR {{number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                </p>
                                                <div class="d-flex">
                                                    <button class="btn btn-danger unpaid-button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#ModalHall"
                                                        data-package-name="{{ $booking->package_name }}"
                                                        data-total-price="{{ $booking->total_price }}"
                                                        data-id-booking="{{ $booking->booking_id }}">
                                                        Unpaid
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="ModalHall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
                                    data-bs-keyboard="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #563d7c;">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: #DFB6B2;"><strong>Detail Pemesanan</strong></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5><strong>Package Name:</strong> <span id="modalPackageName"></span> </h5>
                                                <hr>
                                                <form action="{{ route('paymentForHall', ['id' => $booking->booking_id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <h4 class="card-title text-center">Payment</h4>
                                                    <div class="payment-options">
                                                        <h5>Payment Options</h5>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="creditCard" value="Credit Card">
                                                            <label class="form-check-label" for="creditCard">Credit Card</label>
                                                            <img src="{{ asset('images/creditCard.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="bcaVA" value="BCA Virtual Account">
                                                            <label class="form-check-label" for="bcaVA">BCA Virtual Account</label>
                                                            <img src="{{ asset('images/bcaVA.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="bankTransfer" value="Bank Transfer">
                                                            <label class="form-check-label" for="bankTransfer">Bank Transfer</label>
                                                            <img src="{{ asset('images/bank.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="ovo" value="OVO">
                                                            <label class="form-check-label" for="ovo">OVO</label>
                                                            <img src="{{ asset('images/ovo.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="indodana" value="Indodana">
                                                            <label class="form-check-label" for="indodana">Indodana</label>
                                                            <img src="{{ asset('images/indodana.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                    </div>
                                                    <hr>
                
                                                    <div class="price-detail mt-4" style="font-size:73%">
                                                            <div class="d-flex justify-content-between">
                                                                <p><strong>Total Price</strong></p>
                                                                <p id="modalTotalPrice"></p>
                                                            </div>
                                                    </div>
                
                                                    <button id="continuePaymentButton" type="submit" class="btn w-100 mt-4"
                                                        style="background-color: #824D69; border: none; text-decoration: none; color: white;font-weight:bold; height:35px"
                                                        disabled>
                                                        Continue Payment
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    style="background-color: #824D69;">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                            @elseif($booking->id_room && $booking->id_room_type != null)
                                <div class="card mb-3 mx-auto" style="max-width: 85%; margin-top: 20px">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 250px">
                                            <img src="{{ asset('AsetGambarRoom/' . $booking->room_picture) }}"
                                                class="img-fluid rounded-start" alt="pict"
                                                style="width: 300px; height: 250px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-8" style="margin-left: 0px;">
                                            <div class="card-body">
                                                <h2 class="card-title"><strong>{{ $booking->name_type }}</strong></h2>
                                                <p style="margin-bottom:0;">Booking Date :
                                                    <strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }} -
                                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</strong>
                                                </p>
                                                <p style="margin-bottom: 0;">Extra Bed:
                                                    <?php
                                                        if($booking->extra_bed == 0){
                                                            $booking->extra_bed = "No";
                                                        } else {
                                                            $booking->extra_bed = "Yes";
                                                        }
                                                    ?>
                                                    <strong>{{ $booking->extra_bed }}</strong>
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-end flex-column" style="position: absolute; bottom: 10px; right: 10px;">
                                                <p style="margin-bottom: 0;">Total Price:
                                                    <strong>IDR {{number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                </p>
                                                <div class="d-flex">
                                                    <button class="btn btn-danger unpaid-button" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#ModalRoom"
                                                        data-room-name="{{ $booking->name_type }}"
                                                        data-room-price="{{ $booking->total_price }}"
                                                        data-id-booking-room="{{ $booking->booking_id }}"
                                                        data-id-room-type="{{ $booking->id_type }}">
                                                        Unpaid
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="ModalRoom" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #563d7c;">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: #DFB6B2;">
                                                    <strong>Detail Pemesanan</strong>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Package Name: <span id="modalRoomName"></span></p>
                                                <hr>
                                                <form id="paymentForm" action="{{ route('paymentForRoom', ['id' => $booking->booking_id, 'idRoomType' => $booking->id_type]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <h4 class="card-title text-center">Payment</h4>
                                                    <div class="payment-options">
                                                        <h5>Payment Options</h5>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="creditCard" value="Credit Card">
                                                            <label class="form-check-label" for="creditCard">Credit Card</label>
                                                            <img src="{{ asset('images/creditCard.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="bcaVA" value="BCA Virtual Account">
                                                            <label class="form-check-label" for="bcaVA">BCA Virtual Account</label>
                                                            <img src="{{ asset('images/bcaVA.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="bankTransfer" value="Bank Transfer">
                                                            <label class="form-check-label" for="bankTransfer">Bank Transfer</label>
                                                            <img src="{{ asset('images/bank.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="ovo" value="OVO">
                                                            <label class="form-check-label" for="ovo">OVO</label>
                                                            <img src="{{ asset('images/ovo.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                        <hr>
                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="indodana" value="Indodana">
                                                            <label class="form-check-label" for="indodana">Indodana</label>
                                                            <img src="{{ asset('images/indodana.png') }}"
                                                                style="height: 20px; float: right;">
                                                        </div>
                                                    </div>
                                                    <hr>
                
                                                    <div class="price-detail mt-4" style="font-size:73%">
                                                            <div class="d-flex justify-content-between">
                                                                <p><strong>Total Price</strong></p>
                                                                <p id="modalTotalPrice"></p>
                                                            </div>
                                                    </div>
                
                                                    <button id="continuePaymentButton" type="submit" class="btn w-100 mt-4"
                                                        style="background-color: #824D69; border: none; text-decoration: none; color: white;font-weight:bold; height:35px"
                                                        disabled>
                                                        Continue Payment
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #824D69;">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-10 mx-auto">
                        <br><br>
                        <h2 style="color: #DFB6B2">Transaction History</h2>
                        <hr style="background-color: #DFB6B2; height: 3px; border: none;">

                        @foreach ($paidBookings as $booking)
                            @if ($booking->id_hall_package && $booking->id_hall_package != null)
                                <div class="card mb-3 mx-auto" style="max-width: 85%; margin-top: 20px">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 250px">
                                            <img src="{{ asset('AsetGambar/' . $booking->package_picture) }}"
                                                class="img-fluid rounded-start" alt="pict"
                                                style="width: 300px; height: 250px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-8" style="margin-left: 0px;">
                                            <div class="card-body">
                                                <h2 class="card-title"><strong>{{ $booking->package_name }}</strong>
                                                </h2>
                                                <p style="margin-bottom:0;">Booking Date :
                                                    <strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</strong>
                                                </p>
                                                <p style="margin-bottom: 0;">Attendee Number:
                                                    <strong>{{ $booking->attendee_number }}</strong>
                                                </p>
                                                <p style="margin-bottom: 0;">Payment Method:
                                                    <strong>{{ $booking->payment_method }}</strong>
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-end flex-column" style="position: absolute; bottom: 10px; right: 10px;">
                                                <p style="margin-bottom: 0;">Total Price:
                                                    <strong>IDR {{number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                </p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2">Paid</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($booking->id_room && $booking->id_room_type != null)
                                <div class="card mb-3 mx-auto" style="max-width: 85%; margin-top: 20px">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 250px">
                                            <img src="{{ asset('AsetGambarRoom/' . $booking->room_picture) }}"
                                                class="img-fluid rounded-start" alt="pict"
                                                style="width: 300px; height: 250px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-8" style="margin-left: 0px;">
                                            <div class="card-body">
                                                <h2 class="card-title"><strong>{{ $booking->name_type }}</strong></h2>
                                                <p style="margin-bottom:0;">Booking Date :
                                                    <strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</strong>
                                                </p>
                                                <p style="margin-bottom: 0;">Extra Bed:
                                                    <?php
                                                        if($booking->extra_bed == 0){
                                                            $booking->extra_bed = "No";
                                                        } else {
                                                            $booking->extra_bed = "Yes";
                                                        }
                                                    ?>
                                                    <strong>{{ $booking->extra_bed }}</strong>
                                                </p>
                                                <p style="margin-bottom: 0;">Payment Method:
                                                    <strong>{{ $booking->payment_method }}</strong>
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-end flex-column" style="position: absolute; bottom: 10px; right: 10px;">
                                                <p style="margin-bottom: 0;">Total Price:
                                                    <strong>IDR {{number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                </p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2">Paid</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <br><br><br><br><br>
        </div>
    </main>
    <br><br><br><br><br>
    <footer>
        <div class="footer-container" style="background-color: #2A114B;">
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
                    <li>Terms & Condition</li>
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
                <h6 style="color: white;">Subscribe to our newslater</h6>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email Adress"
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">OK</button>
                </div>
            </div>
        </div>
    </footer>
</body>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('js/swiper_script.min.js') }} "></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function previewImage() {
        const file = document.getElementById('profilePictureInput').files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            document.getElementById('profilePreview').src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

<script>
$(document).ready(function () {
    $('.unpaid-button').click(function (e) {
        e.preventDefault();

        $('#exampleModal').modal('show');
    });
});
</script>

<script>
    $('#ModalHall').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var packageName = button.data('package-name');
        var totalPrice = button.data('total-price');

        var modal = $(this);
        modal.find('#modalPackageName').text(packageName);
        modal.find('#modalTotalPrice').text(totalPrice.toLocaleString());
    });
</script>

<script>
$(document).ready(function () {
    $('.unpaid-button').on('click', function () {
        var packageName = $(this).data('package-name');
        var totalPrice = $(this).data('total-price');
        var idBooking = $(this).data('id-booking');

        $('#modalPackageName').text(packageName);
        $('#totalPrice').val(totalPrice);
        $('#packageName').val(packageName);
        $('#idBooking').val(idBooking);
    });
});
</script>

<script>
    $('#ModalRoom').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var packageName = button.data('room-name');
        var totalPrice = button.data('room-price');

        var modal = $(this);
        modal.find('#modalRoomName').text(packageName);
        modal.find('#modalTotalPrice').text(totalPrice.toLocaleString());
    });
</script>

<script>
    $(document).ready(function () {
        $('.unpaid-button').on('click', function () {
            var roomName = $(this).data('room-name');
            var totalPrice = $(this).data('room-price');
            var idBooking = $(this).data('id-booking-room');
            var idRoomType = $(this).data('id-room-type');

            $('#modalRoomName').text(roomName);
            $('#totalPrice').val(totalPrice);
            $('#packageName').val(roomName);
            $('#idBooking').val(idBooking);
            $('#idRoomType').val(idRoomType);
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
        const continueButton = document.getElementById("continuePaymentButton");
        function checkPaymentSelection() {
            let isOptionSelected = false;
            paymentOptions.forEach(option => {
                if (option.checked) {
                    isOptionSelected = true;
                }
            });
            continueButton.disabled = !isOptionSelected;
        }

        paymentOptions.forEach(option => {
            option.addEventListener("change", checkPaymentSelection);
        });
    });
</script>
</html>
