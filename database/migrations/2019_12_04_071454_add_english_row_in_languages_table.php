<?php

use App\Language;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnglishRowInLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $reqLanguage = Language::where('language_code', 'en')->first();
        if (!$reqLanguage) {
            $language = new Language();

            $language->language_name = 'English';
            $language->language_code = 'en';
            $language->status = 'enabled';

            $language->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $reqLanguage = Language::where('language_code', 'en')->first();
        if ($reqLanguage) {
            $reqLanguage->delete();
        }
    }
}
