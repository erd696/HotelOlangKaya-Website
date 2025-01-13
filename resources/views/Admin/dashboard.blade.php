<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminStyle/adminDashboardStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/poppins.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin Home</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin_home') }}">
                <strong>Hotel</strong><span class="text-appbar-second-color"><strong>OlangKaya</strong></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="{{ route('Admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('admin_room_master') }}">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('admin_hall_package_master') }}">Hall
                            Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Admin.users') }}">User Management</a>
                    </li>
                </ul>
            </div>
            @if (auth('admin')->check())
                <div>
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="background-color: white; color: black; border: none;">
                            <img src="{{ asset('AsetGambar/' . auth('admin')->user()->admin_picture) }}" alt="pict"
                                class="profile-img-nav">
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
                    <a href="{{ route('login') }}"
                        style="text-decoration: none; color: white; border-bottom: 2px solid white;">
                        <strong>Login</strong>
                    </a>
                </button>
            @endif
        </div>
    </nav>
    <main>
        <div class="container mt-5" style="max-width: 1300px;">
            <div class="row">
                <div class="col-md-3">
                    <div class="card shadow-sm p-3 mb-4 rounded" style="border-radius: 15px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><strong>Total User</strong></h5>
                                <h2 class="display-6">{{ $user }}</h2>
                                <div class="text-success">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Up from last month</span>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-users fa-3x"
                                    style="color: #ffb3b3; background-color: #ffe6e6; border-radius: 50%; padding: 15px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm p-3 mb-4 rounded" style="border-radius: 15px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><strong>Total Revenue</strong></h5>
                                <h2 class="display-6">
                                    IDR
                                    @if ($revenue >= 1000000)
                                        {{ round($revenue / 1000000) }}M
                                    @elseif($revenue >= 1000)
                                        {{ round($revenue / 1000) }}K
                                    @else
                                        {{ $revenue }}
                                    @endif
                                </h2>

                                <div class="text-success">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Up from last month</span>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-dollar-sign fa-3x"
                                    style="color: #ffd700; background-color: #fff4c2; border-radius: 50%; padding: 15px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm p-3 mb-4 rounded" style="border-radius: 15px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><strong>Room Booked</strong></h5>
                                <h2 class="display-6">{{ $transaksiKamar }}</h2>
                                <div class="text-success">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Up from last month</span>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-bed fa-3x"
                                    style="color: #a3e5b1; background-color: #e7f9ee; border-radius: 50%; padding: 15px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm p-3 mb-4 rounded" style="border-radius: 15px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><strong>Hall Booked</strong></h5>
                                <h2 class="display-6">{{ $transaksiHall }}</h2>
                                <div class="text-success">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Up from last month</span>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-hotel fa-3x"
                                    style="color: #ffd700; background-color: #fff4c2; border-radius: 50%; padding: 15px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><strong>Recent Booking</strong></h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Booked</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentBookings as $booking)
                                            @if ($booking->id_booking_kamar)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</td>
                                                    <td>{{ $booking->customer }}</td>
                                                    <td>{{ $booking->books }}</td>
                                                    <td>IDR {{ formatCurrency($booking->total) }}</td>
                                                    @if ($booking->statusPayment != 0)
                                                        @if ($booking->statusKamar == 0)
                                                            <td><button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#ModalRoom{{ $booking->id_transaksi_kamar }}"
                                                                data-id="{{ $booking->id_transaksi_kamar }}">
                                                                Check Out
                                                            </button></td>
                                                        @else
                                                            <td><button class="btn btn-success btn-sm">Done</button></td>
                                                        @endif
                                                    @else
                                                        <td><button class="btn btn-warning btn-sm">Unpaid</button></td>
                                                    @endif
                                                </tr>

                                                <div class="modal fade" id="ModalRoom{{ $booking->id_transaksi_kamar }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <form action="{{ route('Admin.checkOutRoom', ['id' => $booking->id_transaksi_kamar]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #563d7c;">
                                                                    <h5 class="modal-title" id="exampleModalLabel" style="color: #DFB6B2;"><strong>Check Out This Booking ?</strong></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #824D69;">Close</button>
                                                                    <button type="submit" class="btn btn-danger" style="background-color: #563d7c;">Check Out</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>


                                            @elseif ($booking->id_booking_hall)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</td>
                                                    <td>{{ $booking->customer }}</td>
                                                    <td>{{ $booking->books }}</td>
                                                    <td>IDR {{ formatCurrency($booking->total) }}</td>
                                                    @if ($booking->statusPayment != 0)
                                                        @if ($booking->statusHall == 0)
                                                        <td><button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#ModalHall{{ $booking->id_transaksi_hall }}"
                                                                data-id="{{ $booking->id_transaksi_hall }}">
                                                                Check Out
                                                            </button></td>
                                                        @else
                                                            <td><button class="btn btn-success btn-sm">Done</button></td>
                                                        @endif
                                                    @else
                                                        <td><button class="btn btn-warning btn-sm">Unpaid</button></td>
                                                    @endif
                                                </tr>

                                                <div class="modal fade" id="ModalHall{{ $booking->id_transaksi_hall }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <form action="{{ route('Admin.checkOutHall', ['id' => $booking->id_transaksi_hall]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #563d7c;">
                                                                    <h5 class="modal-title" id="exampleModalLabel" style="color: #DFB6B2;"><strong>Check Out This Booking ?</strong></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #824D69;">Close</button>
                                                                    <button type="submit" class="btn btn-danger" style="background-color: #563d7c;">Check Out</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><strong>Booked Room</strong></h5>
                            </div>
                            <div class="card-body">
                                @foreach ($bookedRooms as $room)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $room->room_type_name }}
                                        <span class="badge bg-primary rounded-pill">{{ $room->total_booked }}
                                            Rooms</span>
                                    </li>
                                @endforeach
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><strong>Booked Hall Package</strong></h5>
                            </div>
                            <div class="card-body">
                                @foreach ($bookedHalls as $hall)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $hall->package_name }}
                                        <span class="badge bg-primary rounded-pill">{{ $hall->total_booked }}
                                            Halls</span>
                                    </li>
                                @endforeach
                            </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function changeTable(selection) {
        var userTable = document.getElementById('tabel-pengguna');
        var adminTable = document.getElementById('tabel-admin');
        var dropdownButton = document.getElementById('dropdownMenuButton');

        if (selection === 'user') {
            userTable.style.display = 'block';
            adminTable.style.display = 'none';
            dropdownButton.textContent = 'Data Pengguna';
        } else {
            userTable.style.display = 'none';
            adminTable.style.display = 'block';
            dropdownButton.textContent = 'Data Admin';
        }
    }
    window.onload = function() {
        changeTable('user');
    }
</script>

<script>
    $('#ModalRoom').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var bookingId = button.data('id');

    });
</script>

<script>
    $('#ModalHall').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var bookingId = button.data('id');

    });
</script>



</html>
