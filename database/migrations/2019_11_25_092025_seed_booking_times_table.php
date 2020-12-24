<?php

use App\BookingTime;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedBookingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $bookingTimes = BookingTime::select('id')->get();

        if ($bookingTimes->count() === 0) {
            BookingTime::insert([
                ['day' => 'monday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
                ['day' => 'tuesday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
                ['day' => 'wednesday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
                ['day' => 'thursday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
                ['day' => 'friday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
                ['day' => 'saturday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
                ['day' => 'sunday', 'start_time' => '10:00:00', 'end_time' => '20:00:00'],
            ]);
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
