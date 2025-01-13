<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Payment;
use App\Models\TransaksiKamar;
use App\Models\TransaksiHall;
use App\Models\Bookings;
use App\Models\RoomType;
use App\Models\HallPackage;
use App\Models\Rooms;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{

    public function indexDashboard(){
        $user = User::all()->count();

        $revenue = Payment::all()->sum('total_price');

        $transaksiKamar = TransaksiKamar::all()->count();
        $transaksiHall = TransaksiHall::all()->count();

        $recentBookings = Bookings::join('users', 'bookings.id_user', '=', 'users.id_user')
            ->leftJoin('transaksi_hall', 'bookings.id_booking', '=', 'transaksi_hall.id_booking')
            ->leftJoin('transaksi_kamar', 'bookings.id_booking', '=', 'transaksi_kamar.id_booking')
            ->join('payment', 'bookings.id_booking', '=', 'payment.id_booking')
            ->select(
                'bookings.check_in_date as date',
                'transaksi_kamar.status_checkout as statusKamar',
                'transaksi_hall.status_checkout as statusHall',
                'transaksi_kamar.id_booking as id_booking_kamar',
                'transaksi_hall.id_booking as id_booking_hall',
                'payment.payment_status as statusPayment',
                'transaksi_kamar.id_transaksi_kamar as id_transaksi_kamar',
                'transaksi_hall.id_transaksi_hall as id_transaksi_hall',
                \DB::raw('CONCAT(users.first_name, " ", users.last_name) as customer'),
                \DB::raw('CASE 
                            WHEN transaksi_hall.id_booking IS NOT NULL THEN "Hall" 
                            WHEN transaksi_kamar.id_booking IS NOT NULL THEN "Room" 
                            ELSE "N/A" 
                        END as books'),
                'payment.total_price as total'
            )
            ->orderByDesc('bookings.check_in_date')
            ->get();

        $bookedRooms = RoomType::leftJoin('rooms', 'room_type.id_room_type', '=', 'rooms.id_room_type')
            ->leftJoin('transaksi_kamar', 'rooms.id_room', '=', 'transaksi_kamar.id_room')
            ->leftJoin('bookings', 'transaksi_kamar.id_booking', '=', 'bookings.id_booking')
            ->select('room_type.name_type as room_type_name', 
                     \DB::raw('COALESCE(COUNT(transaksi_kamar.id_booking), 0) as total_booked'))
            ->groupBy('room_type.id_room_type', 'room_type.name_type')
            ->get();

        $bookedHalls = HallPackage::leftJoin('transaksi_hall', 'hall_package.id_hall_package', '=', 'transaksi_hall.id_hall_package')
            ->leftJoin('bookings', 'transaksi_hall.id_booking', '=', 'bookings.id_booking')
            ->select('hall_package.package_name', 
                     \DB::raw('COALESCE(COUNT(transaksi_hall.id_booking), 0) as total_booked'))
            ->groupBy('hall_package.package_name')
            ->get();

        return view('Admin.dashboard', compact('user', 'revenue', 'transaksiKamar', 'transaksiHall', 'recentBookings', 'bookedRooms', 'bookedHalls'));
    }

    public function index(){
        $user = User::all();
        $admin = Admin::all();

        return view('Admin.admin_user_management', compact('user', 'admin'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('Admin.AdminCreateEdit.ManagementCE.admin_user_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',id_user',
            'telepon' => 'required|max:15',
            'user_picture',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'telepon' => $validatedData['telepon'],
        ]);

        if ($request->hasFile('user_picture')) {
            $image = $request->file('user_picture');
            $imageName = $image->getClientOriginalName();

            if ($user->user_picture && $user->user_picture !== 'blank-profile-picture.jpg') {
                $oldImagePath = public_path('AsetGambar/' . $user->user_picture);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image->move(public_path('AsetGambar'), $imageName);

            $user->user_picture = $imageName;
            $user->save();
        }

        return redirect()->route('Admin.users')->with('success', 'User updated successfully!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->user_picture) {
            Storage::delete('public/' . $user->user_picture);
        }

        $user->delete();
        return redirect()->route('Admin.users')->with('success', 'User deleted successfully!');
    }

    public function createAdmin(){
        return view('Admin.AdminCreateEdit.ManagementCE.admin_create');
    }

    public function storeAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'admin_name' => 'required|max:255',
            'admin_email' => 'required|email|max:255|unique:admin',
            'admin_password' => 'required|min:8',
            'admin_telp' => 'required|max:15',
            'admin_picture',
        ]);

        if ($request->hasFile('admin_picture')) {
            $image = $request->file('admin_picture');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('AsetGambar'), $imageName);

            $validatedData['admin_picture'] = $imageName;
        }

        $admin = Admin::create([
            'admin_name' => $validatedData['admin_name'],
            'admin_email' => $validatedData['admin_email'],
            'admin_password' =>$validatedData['admin_password'],
            'admin_telp' => $validatedData['admin_telp'],
            'admin_picture' => $validatedData['admin_picture'],
        ]);

        return redirect()->route('Admin.users')->with('success', 'Admin created successfully!');
    }

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        return view('Admin.AdminCreateEdit.ManagementCE.admin_edit', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $validatedData = $request->validate([
            'admin_name' => 'required|max:255',
            'admin_email' => 'required|email|max:255|unique:admin,admin_email,' . $id . ',id_admin',
            'admin_password' => 'required|min:8',
            'admin_telp' => 'required|max:15',
            'admin_picture'
        ]);

        $admin = Admin::findOrFail($id);

        $admin->update([
            'admin_name' => $validatedData['admin_name'],
            'admin_email' => $validatedData['admin_email'],
            'admin_password' => $validatedData['admin_password'],
            'admin_telp' => $validatedData['admin_telp'],
        ]);

        if ($request->hasFile('admin_picture')) {
            $image = $request->file('admin_picture');
            $imageName = $image->getClientOriginalName();

            if ($admin->admin_picture && $admin->admin_picture !== 'blank-profile-picture.jpg') {
                $oldImagePath = public_path('AsetGambar/' . $admin->admin_picture);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image->move(public_path('AsetGambar'), $imageName);

            $admin->admin_picture = $imageName;
            $admin->save();
        }

        return redirect()->route('Admin.users')->with('success', 'User updated successfully!');
    }


    public function destroyAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->admin_picture) {
            Storage::delete('public/' . $admin->admin_picture);
        }

        $admin->delete();
        return redirect()->route('Admin.users')->with('success', 'User deleted successfully!');
    }

    public function checkOutRoom($id)
    {
        $transaksiKamar = TransaksiKamar::find($id);
    
        $transaksiKamar->update([
            'status_checkout' => 1,
        ]);

        $room = Rooms::find($transaksiKamar->id_room);
        $room->update([
            'status' => 0,
        ]);
    
        return redirect()->route('Admin.dashboard')->with('success', 'Room checked out successfully!');
    }
    

    public function checkOutHall($id){
        $transaksiHall = TransaksiHall::find($id);

        $transaksiHall->update([
            'status_checkout' => 1,
        ]);

        return redirect()->route('Admin.dashboard')->with('success', 'Hall checked out successfully!');
    }

}
