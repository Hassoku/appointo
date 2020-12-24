<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\TaxSetting;

class CreateTaxSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tax_name');
            $table->float('percent');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
        });

        TaxSetting::create(['tax_name' => 'GST', 'percent' => 18]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_settings');
    }
}
