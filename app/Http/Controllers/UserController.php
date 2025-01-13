<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isNull;
use App\Models\Bookings;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    use ValidatesRequests;

    public function register(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telepon' => 'required|string|max:255',
            'user_picture',
        ]);

        $admin = Admin::where('admin_email', $request->email)->first();
        if ($admin) {
            return redirect()->route('login')->with('error', 'Email already registered');
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'telepon' => $request->telepon,
            'user_picture' => 'blank-profile-picture.jpg',
        ]);

        return redirect()->route('login')->with('success', 'User registered successfully! Please login to continue.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('admin_email', $request->email)->first();
        if ($admin && $admin->admin_password === $request->password) {
            auth('admin')->login($admin);
            session(['admin_logged_in_at' => now()]);
            return redirect()->route('admin_home')->with('success', 'Login successful');
        }

        $user = User::where('email', $request->email)->first();
        if ($user && $user->password === $request->password) {
            auth()->login($user);
            return redirect()->route('home')->with('success', 'Login successful');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Email or password is incorrect.',
            'password' => 'Email or password is incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        if (auth('admin')->check()) {
            auth('admin')->logout();
        } elseif (auth()->check()) {
            auth()->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }


    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telepon' => 'required|string|max:255',
            'user_picture'
        ]);
        $image = $request->file('user_picture');
        if (is_null($image)) {
            $img = $user->user_picture;
        } else {
            $imgLocal = $image->move(public_path('AsetGambar'), $image->getClientOriginalName());
            $img = $image->getClientOriginalName();
        
            if ($user->user_picture !== 'blank-profile-picture.jpg') {
                File::delete(public_path('AsetGambar/'.$user->user_picture));
            }
        }

        $user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'telepon' => $validatedData['telepon'],
            'user_picture' => $img,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function showProfile(){
        $user = auth()->user();

        $unpaidBookings = DB::table('bookings')
            ->join('payment', 'bookings.id_booking', '=', 'payment.id_booking')
            ->leftJoin('transaksi_hall', 'bookings.id_booking', '=', 'transaksi_hall.id_booking')
            ->leftJoin('transaksi_kamar', 'bookings.id_booking', '=', 'transaksi_kamar.id_booking')
            ->leftJoin('hall_package', 'transaksi_hall.id_hall_package', '=', 'hall_package.id_hall_package')
            ->leftJoin('rooms', 'transaksi_kamar.id_room', '=', 'rooms.id_room')
            ->leftJoin('room_type', 'rooms.id_room_type', '=', 'room_type.id_room_type')
            ->where('bookings.id_user', $user->id_user)
            ->where('payment.payment_status', 0)
            ->select(
                'bookings.id_booking as booking_id',
                'bookings.*', 'payment.*', 
                'hall_package.package_name', 'hall_package.package_picture', 
                'room_type.name_type', 'room_type.room_picture', 'room_type.id_room_type as id_type', 
                'transaksi_hall.*', 'transaksi_kamar.*', 'rooms.id_room_type as id_room_type'
            )
            ->get();

        $paidBookings = DB::table('bookings')
            ->join('payment', 'bookings.id_booking', '=', 'payment.id_booking')
            ->leftJoin('transaksi_hall', 'bookings.id_booking', '=', 'transaksi_hall.id_booking')
            ->leftJoin('transaksi_kamar', 'bookings.id_booking', '=', 'transaksi_kamar.id_booking')
            ->leftJoin('hall_package', 'transaksi_hall.id_hall_package', '=', 'hall_package.id_hall_package')
            ->leftJoin('rooms', 'transaksi_kamar.id_room', '=', 'rooms.id_room')
            ->leftJoin('room_type', 'rooms.id_room_type', '=', 'room_type.id_room_type')
            ->where('bookings.id_user', $user->id_user)
            ->where('payment.payment_status', 1)
            ->select(
                'bookings.id_booking as booking_id',
                'bookings.*', 'payment.*', 
                'hall_package.package_name', 'hall_package.package_picture', 
                'room_type.name_type', 'room_type.room_picture', 
                'transaksi_hall.*', 'transaksi_kamar.*', 'rooms.id_room_type as id_room_type')
            ->get();
        
        return view('profile', compact('unpaidBookings', 'paidBookings'));
    }

    public function updatePassword(Request $request, $id){
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
        ]);
        if ($validatedData['current_password'] !== $user->password) {
            return redirect()->route('profile')->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => $validatedData['new_password'],
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully');
    }

}
