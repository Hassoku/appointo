<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_theme_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        DB::table('front_theme_settings')->insert([
            'primary_color' => '#414552',
            'secondary_color' => '#788AE2'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_theme_settings');
    }
}
