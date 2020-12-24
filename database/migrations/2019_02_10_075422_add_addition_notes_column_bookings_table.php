<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionNotesColumnBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'bookings', function (Blueprint $table) {
                $table->text('additional_notes')->nullable()->after('source');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'bookings', function (Blueprint $table) {
                $table->dropColumn(['additional_notes']);
            }
        );
    }
}
