<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeTaxColumnNullableBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('ALTER TABLE `bookings` CHANGE `tax_name` `tax_name` VARCHAR(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;');
       DB::statement('ALTER TABLE `bookings` CHANGE `tax_percent` `tax_percent` DOUBLE(8,2) NULL;');
       DB::statement('ALTER TABLE `bookings` CHANGE `tax_amount` `tax_amount` DOUBLE(8,2) NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `bookings` CHANGE `tax_name` `tax_name` VARCHAR(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `bookings` CHANGE `tax_percent` `tax_percent` DOUBLE(8,2) NOT NULL;');
        DB::statement('ALTER TABLE `bookings` CHANGE `tax_amount` `tax_amount` DOUBLE(8,2) NOT NULL');
    }
}
