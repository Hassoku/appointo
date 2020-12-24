<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SmtpSetting;

class CreateSmtpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mail_driver');
            $table->string('mail_host');
            $table->string('mail_port');
            $table->string('mail_username');
            $table->string('mail_password');
            $table->string('mail_from_name');
            $table->string('mail_from_email');
            $table->enum('mail_encryption', ['none', 'tls', 'ssl']);
            $table->timestamps();
        });

        $smtp = new SmtpSetting();
        $smtp->mail_driver = 'mail';
        $smtp->mail_host = 'smtp.gmail.com';
        $smtp->mail_port = '587';
        $smtp->mail_username = 'myemail@gmail.com';
        $smtp->mail_password = 'mypassword';
        $smtp->mail_from_name = 'Appointo';
        $smtp->mail_from_email = 'myemail@gmail.com';
        $smtp->mail_encryption = 'none';
        $smtp->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smtp_settings');
    }
}
