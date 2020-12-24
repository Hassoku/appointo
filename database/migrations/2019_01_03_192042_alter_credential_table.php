<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCredentialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `payment_gateway_credentials` CHANGE `stripe_status` `stripe_status` ENUM('active','deactive') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deactive'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `payment_gateway_credentials` CHANGE `paypal_status` `paypal_status` ENUM('active','deactive') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deactive'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `bookings` CHANGE `payment_status` `payment_status` ENUM('pending','completed') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending'");

        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->enum('offline_payment', [0,1])->default(1)->after('paypal_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->dropColumn(['offline_payment']);
        });
    }
}
