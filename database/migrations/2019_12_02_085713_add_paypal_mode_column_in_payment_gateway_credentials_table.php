<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaypalModeColumnInPaymentGatewayCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payment_gateway_credentials', 'paypal_mode')) {
            Schema::table('payment_gateway_credentials', function (Blueprint $table) {
                $table->enum('paypal_mode', ['sandbox', 'live'])->default('sandbox')->after('paypal_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('payment_gateway_credentials', 'paypal_mode')) {
            Schema::table('payment_gateway_credentials', function (Blueprint $table) {
                $table->dropColumn('paypal_mode');
            });
        }
    }
}
