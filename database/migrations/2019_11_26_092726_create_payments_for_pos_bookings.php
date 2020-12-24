<?php

use App\Booking;
use App\CompanySetting;
use App\Payment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsForPosBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $bookings = Booking::select(['id', 'date_time', 'payment_gateway', 'amount_to_pay', 'payment_status', 'source'])->where('source', 'pos')->get();
        $settings = CompanySetting::first();

        if ($bookings->count() > 0) {
            foreach ($bookings as $booking) {
                if (!$booking->payment) {
                    $payment = new Payment();

                    $payment->currency_id = $settings->currency_id;
                    $payment->booking_id = $booking->id;
                    $payment->amount = $booking->amount_to_pay;
                    $payment->gateway = $booking->payment_gateway;
                    $payment->status = $booking->payment_status;
                    $payment->paid_on = $booking->utc_date_time;
                    $payment->created_at = $booking->utc_date_time;
                    $payment->updated_at = $booking->utc_date_time;

                    $payment->save();
                }
            }
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
