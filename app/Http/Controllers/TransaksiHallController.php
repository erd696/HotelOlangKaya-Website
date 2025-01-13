<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiHall;
use App\Models\HallPackage;
use App\Models\Bookings;
use App\Http\Controllers\PaymentController; 


class TransaksiHallController extends Controller
{

    public function index()
    {
        $hallPackages = HallPackage::latest()->get();
        return view('Booking.choose_hall_package', compact('hallPackages'));
    }

    public function show($id_booking, $hall_package_id)
    {
        $booking = Bookings::find($id_booking);
        if (!$booking) {
            return redirect()->route('home')->withErrors('Booking not found');
        }

        $hallPackages = HallPackage::find($hall_package_id);

        if (!$hallPackages) {
            return redirect()->route('home')->withErrors('Hall package not found');
        }

        return view('Booking.booking_hall_process', compact('booking', 'hallPackages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'attendee_number' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $id_booking = $request->id_booking;
        $id_package = $request->id_hall_package;

        $transaksi = TransaksiHall::create([
            'id_booking' => $id_booking,
            'id_hall_package' => $id_package,
            'event_name' => $request->event_name,
            'attendee_number' => $request->attendee_number,
            'status_checkout' => 0,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $booking = Bookings::find($id_booking);
        $hallPackage = HallPackage::find($id_package);

        session(['id_booking' => $id_booking, 'booking' => $booking, 'hallPackage' => $hallPackage, 'transaksi' => $transaksi]);

        $paymentController = new PaymentController();
        $paymentController->pendingPaymentHall($id_booking);

        return redirect()->route('paymentHall', ['id' => $id_booking]);
    }

    public function destroy($id)
    {
        $booking = Bookings::find($id);

        $booking->delete();

        return redirect()->route('choose_hall_package');
    }

}
