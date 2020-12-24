<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleBookingColumnBookingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_times', function (Blueprint $table) {
            $table->enum('multiple_booking', ['yes', 'no'])->default('yes')->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_times', function (Blueprint $table) {
            $table->dropColumn(['multiple_booking']);
        });
    }
}
