<?php

use App\Booking;
use App\BookingTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBookingTimesAndBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $bookingTimes = BookingTime::all();

        foreach ($bookingTimes as $bookingTime) {
            $bookingTime->start_time = Carbon::createFromFormat('H:i A', $bookingTime->utc_start_time)->toTimeString();
            $bookingTime->end_time = Carbon::createFromFormat('H:i A', $bookingTime->utc_end_time)->toTimeString();
            $bookingTime->save();
        }

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            $booking->date_time = $booking->utc_date_time->toDateTimeString();
            $booking->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
