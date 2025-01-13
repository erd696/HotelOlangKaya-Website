<?php

use App\Http\Controllers\TransaksiHallController;
use App\Http\Controllers\TransaksiKamarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HallPackageController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomsController;


Route::post('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/login', [UserController::class, 'login'])->name('user.login');
Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::put('/user/update-password/{id}', [UserController::class, 'updatePassword'])->name('user.updatePassword');


Route::resource('hall_package', HallPackageController::class);
Route::resource('transaksi_hall', TransaksiHallController::class);
Route::resource('room_type', RoomTypeController::class);
Route::resource('transaksi_kamar', TransaksiKamarController::class);
Route::resource('booking', BookingsController::class);
Route::resource('payment', PaymentController::class);

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    } else if (auth('admin')->check()) {
        return redirect()->route('admin_home');
    }

    return view('login');
})->name('login');


Route::get('/register', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    } else if (auth('admin')->check()) {
        return redirect()->route('admin_home');
    }
    return view('register');
})->name('register');

Route::middleware('auth:admin')->group(function () {
    Route::get('room_types/assign/{roomType}', [RoomsController::class, 'assignRoomTypes'])->name('room_types.assign');

    // --- Admin User Managemenr (User) --- //
    Route::get('/admin/users', [AdminController::class, 'index'])->name('Admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('Admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('Admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('Admin.users.destroy');

    // --- Admin User Managemenr (Admin) --- //
    Route::get('/admin/adminAcc/create', [AdminController::class, 'createAdmin'])->name('Admin.users.create');
    Route::post('/admin/adminAcc', [AdminController::class, 'storeAdmin'])->name('Admin.users.store');
    Route::get('/admin/adminAcc/{id}/update', [AdminController::class, 'editAdmin'])->name('Admin.adminAcc.edit');
    Route::put('/admin/adminAcc/{id}/update', [AdminController::class, 'updateAdmin'])->name('Admin.users.updateAdmin');
    Route::delete('/admin/adminAcc/{id}', [AdminController::class, 'destroyAdmin'])->name('Admin.users.deleteAdmin');

    // --- Lain Laine --- //
    Route::get('/admin/dashboard', [AdminController::class, 'indexDashboard'])->name('Admin.dashboard');

    Route::put('/admin/checkOutRoom/{id}', [AdminController::class, 'checkOutRoom'])->name('Admin.checkOutRoom');

    Route::put('/admin/checkOutHall/{id}', [AdminController::class, 'checkOutHall'])->name('Admin.checkOutHall');

    Route::get('/Admin/admin_home', function () {
        return view('Admin.admin_home');
    })->name('admin_home');
    
    Route::get('/Admin/admin_room_master', function () {
        return view('Admin.admin_room_master');
    })->name('admin_room_master');

    Route::get('/Admin/admin_hall_package_master', [HallPackageController::class, 'index'
    ])->name('admin_hall_package_master');
    
    Route::get('/Admin/admin_room_master', [RoomTypeController::class, 'index'
    ])->name('admin_room_master');
    
    Route::get('/Admin/admin_book_report', function () {
        return view('Admin.admin_book_report');
    })->name('admin_book_report');
    
    Route::get('/Admin/admin_user_management', function () {
        return view('Admin.admin_user_management');
    })->name('admin_user_management');
    
    Route::get('/Admin/AdminCreateEdit/admin_room_edit', function () {
        return view('Admin.AdminCreateEdit.admin_room_edit');
    })->name('admin_room_edit');
    
    Route::get('/Admin/AdminCreateEdit/admin_room_create', function () {
        return view('Admin.AdminCreateEdit.admin_room_create');
    })->name('admin_room_create');
    
    Route::get('/Admin/AdminCreateEdit/admin_hall_edit', function () {
        return view('Admin.AdminCreateEdit.admin_hall_edit');
    })->name('admin_hall_edit');
    
    Route::get('/Admin/AdminCreateEdit/admin_hall_create', function () {
        return view('Admin.AdminCreateEdit.admin_hall_create');
    })->name('admin_hall_create');
    
    Route::get('/Admin/AdminCreateEdit/ManagementCE/admin_user_edit', function () {
        return view('Admin.AdminCreateEdit.ManagementCE.admin_user_edit');
    })->name('admin_user_edit');
    
    Route::get('/Admin/AdminCreateEdit/ManagementCE/admin_edit', function () {
        return view('Admin.AdminCreateEdit.ManagementCE.admin_edit');
    })->name('admin_edit');
    
    Route::get('/Admin/AdminCreateEdit/ManagementCE/admin_create', function () {
        return view('Admin.AdminCreateEdit.ManagementCE.admin_create');
    })->name('admin_create');
    
    Route::get('/Admin/AdminCreateEdit/ManagementCE/admin_user_create', function () {
        return view('Admin.AdminCreateEdit.ManagementCE.admin_user_create');
    })->name('admin_user_create');
});

Route::middleware('auth')->group(function (){

    // --- Bookings --- //

    Route::put('/user/update-password/{id}', [UserController::class, 'updatePassword'])->name('user.updatePassword');

    Route::get('/Booking/choose_booking', function () {
        return view('Booking.choose_booking');
    })->name('choose_booking');

    Route::post('/booking/hall/{id}', [BookingsController::class, 'store'
    ])->name('booking.store');

    Route::post('/booking/room/{id}', [BookingsController::class, 'storeRoom'
    ])->name('booking.storeRoom');

    Route::get('/Booking/choose_hall_package', [TransaksiHallController::class, 'index'
    ])->name('choose_hall_package');

    Route::get('/Booking/choose_room', [TransaksiKamarController::class, 'index'
    ])->name('choose_room');


    // --- Payment --- //
    
    Route::get('/Booking/paymentHall/{id}', function ($id) {
        $booking = session('booking');
        $transaksi = session('transaksi');
        $hallPackage = session('hallPackage');
        return view('Booking.paymentHall', compact('id', 'booking', 'transaksi', 'hallPackage'));
    })->name('paymentHall');

    Route::put('/Booking/paymentHall/{id}', [PaymentController::class, 'paymentForHall'])->name('paymentForHall');

    Route::post('/pending_payment_hall/{id}', [PaymentController::class, 'pendingPaymentHall'])->name('pendingPaymentHall');

    Route::get('/Booking/paymentRoom/{id}', function ($id) {
        $booking = session('booking');
        $transaksi = session('transaksi');
        $roomType= session('roomType');
        return view('Booking.paymentRoom', compact('id', 'booking', 'transaksi', 'roomType'));
    })->name('paymentRoom');

    
    Route::put('/Booking/paymentRoom/{id}/{idRoomType}', [PaymentController::class, 'paymentForRoom'])->name('paymentForRoom');

   
    Route::post('/pending_payment_Room/{id}/{idRoom}', [PaymentController::class, 'pendingPaymentRoom'
    ])->name('pendingPaymentRoom');


    // --- Transaksi Hall ---//

    Route::delete('/transaksi_hall/{id}', [TransaksiHallController::class, 'destroy'])->name('transaksi_hall.destroy');

    Route::post('/transaksi-hall/store', [TransaksiHallController::class, 'store'
    ])->name('transaksi_hall.store');

    Route::get('/Booking/booking_hall_process/{id_booking}/{hall_package_id}', [TransaksiHallController::class, 'show'
    ])->name('booking_hall_process');



    // --- Transaksi Room --- //
    Route::delete('/transaksi_room/{id}', [TransaksiKamarController::class, 'destroy'])->name('transaksi_room.destroy');

    Route::post('/transaksi-room/store', [TransaksiKamarController::class, 'store'
    ])->name('transaksi_room.store');

    Route::get('/Booking/booking_room_process/{id_booking}/{room_type_id}', [TransaksiKamarController::class, 'show'
    ])->name('booking_room_process');

    Route::get('/Booking/payment', function () {
        return view('Booking.payment');
    })->name('payment');

    // --- General --- //

    Route::get('/', function () {
        return view('home');
    });
    
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/facility', function () {
        return view('facility');
    })->name('facility');
    
    Route::get('/profile', [UserController::class, 'showProfile'
    ])->name('profile');

});

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/facility', function () {
    return view('facility');
})->name('facility');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');
    
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

    
    