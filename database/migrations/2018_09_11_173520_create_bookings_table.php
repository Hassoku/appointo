<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('date_time');
            $table->enum('status', ['pending', 'in progress', 'completed', 'canceled'])->default('pending');
            $table->string('payment_gateway');
            $table->float('original_amount');
            $table->float('discount');
            $table->string('tax_name');
            $table->float('tax_percent');
            $table->float('tax_amount');
            $table->float('amount_to_pay');
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
        Schema::dropIfExists('bookings');
    }
}
