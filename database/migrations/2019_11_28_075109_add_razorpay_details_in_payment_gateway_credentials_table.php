<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRazorpayDetailsInPaymentGatewayCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->string('razorpay_key')->after('offline_payment')->nullable();
            $table->string('razorpay_secret')->after('razorpay_key')->nullable();
            $table->enum('razorpay_status', ['active', 'deactive'])->default('deactive')->after('razorpay_secret');
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
            $table->dropColumn('razorpay_key');
            $table->dropColumn('razorpay_secret');
            $table->dropColumn('razorpay_status');
        });
    }
}
