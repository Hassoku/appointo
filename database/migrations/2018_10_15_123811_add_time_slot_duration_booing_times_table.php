<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeSlotDurationBooingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_times', function (Blueprint $table) {
            $table->integer('slot_duration')->default(30)->after('status'); //in minutes
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
            $table->dropColumn(['slot_duration']);
        });
    }
}
