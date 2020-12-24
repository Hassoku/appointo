<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('sidebar_bg_color');
            $table->string('sidebar_text_color');
            $table->timestamps();
        });

        DB::table('theme_settings')->insert([
           'primary_color' => '#414552',
            'secondary_color' => '#788AE2',
            'sidebar_bg_color' => '#FFFFFF',
            'sidebar_text_color' => '#5C5C62'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theme_settings');
    }
}
