<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookings;
use App\Models\Payment;
use App\Models\TransaksiHall;
use App\Models\TransaksiKamar;
use App\Models\HallPackage;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function paymentForHall(Request $request, $id)
    {
        $payment = Payment::where('id_booking', $id)->first();

        if (!$payment) {
            $payment = new Payment();
            $payment->id_booking = $id;
        }

        $payment->payment_method = $request->payment_method;
        $payment->payment_date = now();
        $payment->payment_status = 1;
        $payment->save();

        return redirect()->route('profile')->with('success', 'Pembayaran berhasil!');
    }

    public function paymentForRoom(Request $request, $id, $idRoomType)
    {
        $payment = Payment::where('id_booking', $id)->first();

        if (!$payment) {
            $payment = new Payment();
            $payment->id_booking = $id;
        }

        $payment->payment_method = $request->payment_method;
        $payment->payment_date = now();
        $payment->payment_status = 1;
        $payment->save();

        return redirect()->route('profile')->with('success', 'Pembayaran berhasil!');
    }



    public function pendingPaymentHall($id)
    {
        $transaksi_hall = TransaksiHall::where('id_booking', $id)->first();

        if (!$transaksi_hall) {
            return redirect()->route('home')->withErrors('Booking tidak ditemukan');
        }

        $hall_package = HallPackage::where('id_hall_package', $transaksi_hall->id_hall_package)->first();

        if (!$hall_package) {
            return redirect()->route('home')->withErrors('Paket hall tidak ditemukan');
        }

        $booking = Bookings::where('id_booking', $id)->first();

        if (!$booking) {
            return redirect()->route('home')->withErrors('Data booking tidak ditemukan');
        }

        $check_in_date = new \DateTime($booking->check_in_date);
        $check_out_date = new \DateTime($booking->check_out_date);
        $interval = $check_in_date->diff($check_out_date);
        $days = $interval->days;

        $price = $hall_package->price * $days;

        if ($transaksi_hall->attendee_number > $hall_package->capacity) {
            $price += ($transaksi_hall->attendee_number - $hall_package->capacity) * 50000;
        }

        $price += 10000;

        $payment = Payment::create([
            'id_booking' => $id,
            'total_price' => $price,
            'payment_status' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran pending']);
    }

    public function pendingPaymentRoom($id, $idRoomType)
    {
        $transaksi_room = TransaksiKamar::where('id_booking', $id)->first();

        if (!$transaksi_room) {
            return redirect()->route('home')->withErrors('Booking tidak ditemukan');
        }

        $room_type = RoomType::where('id_room_type', $idRoomType)->first();

        if (!$room_type) {
            return redirect()->route('home')->withErrors('Room tidak ditemukan');
        }

        $booking = Bookings::where('id_booking', $id)->first();

        if (!$booking) {
            return redirect()->route('home')->withErrors('Data booking tidak ditemukan');
        }

        $check_in_date = new \DateTime($booking->check_in_date);
        $check_out_date = new \DateTime($booking->check_out_date);
        $interval = $check_in_date->diff($check_out_date);
        $days = $interval->days;

        $price = $room_type->price * $days;

        if ($transaksi_room->extra_bed == 1) {
            $price += 250000;
           
        }

        $price += 10000;

        $payment = Payment::create([
            'id_booking' => $id,
            'total_price' => $price,
            'payment_status' => 0,
        ]);
        return response()->json(['success' => true, 'message' => 'Pembayaran pending']);
    }
}