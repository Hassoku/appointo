<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = new Currency();
        $currency->currency_name = 'US Dollars';
        $currency->currency_code = 'USD';
        $currency->currency_symbol= '$';
        $currency->save();
    }
}
