<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKamar;
use App\Models\RoomType;
use App\Models\Bookings;
use App\Http\Controllers\PaymentController; 
use App\Models\Rooms;
use App\Http\Controllers\RoomsController;

use Illuminate\Support\Facades\Log;

class TransaksiKamarController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::latest()->get();
       
        return view('Booking.choose_room', compact('roomTypes'));
    }

    public function show($id_booking, $room_type_id)
    {
        $booking = Bookings::find($id_booking);
        if (!$booking) {
            return redirect()->route('home')->withErrors('Booking not found');
        }

        $roomTypes = RoomType::find($room_type_id);

        if (!$roomTypes) {
            return redirect()->route('home')->withErrors('Room types not found');
        }

        return view('Booking.booking_room_process', compact('booking', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            
        ]);

        Log::info('Request Data: ', $request->all());

        $id_booking = $request->id_booking;
        $id_type = $request->id_room_type;

        $room = Rooms::where('id_room_type', $id_type)
            ->where('status', 0)->first();
        $idRoom = $room->id_room;
        Log::info('Room Data: ', ['idRoom' => $idRoom]);

        $konfirmasi = !empty($request->extra_bed) ? 1 : 0;

        $transaksi = TransaksiKamar::create([
            'id_booking' => $id_booking,
            'id_room' => $idRoom,
            'extra_bed' => $konfirmasi,
            'status_checkout' => 0,
        ]);

        $booking = Bookings::find($id_booking);
        $roomType = RoomType::find($id_type);

        session(['id_booking' => $id_booking, 'booking' => $booking, 'roomType' => $roomType, 'transaksi' => $transaksi, 'extra_bed' => $konfirmasi]);
        
        $paymentController = new PaymentController();
        $paymentController->pendingPaymentRoom($id_booking, $id_type);

        $roomsController = new RoomsController();
        $roomsController->changeStatus($idRoom);

        return redirect()->route('paymentRoom', ['id' => $id_booking]);
    }

    public function destroy($id)
    {
        $booking = Bookings::find($id);

        $booking->delete();

        return redirect()->route('choose_room');
    }
}