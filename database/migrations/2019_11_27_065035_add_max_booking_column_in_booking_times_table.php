<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxBookingColumnInBookingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_times', function (Blueprint $table) {
            $table->integer('max_booking')->default(0)->after('multiple_booking');
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
            $table->dropColumn('max_booking');
        });
    }
}
