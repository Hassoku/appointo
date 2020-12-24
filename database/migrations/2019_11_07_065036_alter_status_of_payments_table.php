<?php

use App\Payment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterStatusOfPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // get payments with complete status
        $payments = Payment::select('id', 'status')->where('status', 'complete')->get();

        // change payment enum value
        DB::statement("ALTER TABLE `payments` CHANGE `status` `status` ENUM('completed','pending') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending'");

        foreach ($payments as $payment) {
            $payment->status = 'completed';
            $payment->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // get payments with complete status
        $payments = Payment::select('id', 'status')->where('status', 'completed')->get();

        // change payment enum value
        DB::statement("ALTER TABLE `payments` CHANGE `status` `status` ENUM('complete','pending') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending'");

        foreach ($payments as $payment) {
            $payment->status = 'complete';
            $payment->save();
        }
    }
}
