<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedInteger('business_service_id');
            $table->foreign('business_service_id')->references('id')->on('business_services')->onUpdate('cascade')->onDelete('cascade');

            $table->tinyInteger('quantity');
            $table->double('unit_price');
            $table->double('amount');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_items');
    }
}
