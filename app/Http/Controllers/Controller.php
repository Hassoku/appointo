<?php

namespace App\Http\Controllers;

use App\CompanySetting;
use App\FrontThemeSetting;
use App\Helper\Formats;
use App\Language;
use App\Location;
use App\Page;
use App\SmsSetting;
use App\ThemeSetting;
use App\UniversalSearch;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AppBoot;

    public $user;
    public $pageTitle;
    public $settings;
    public $productsCount;

    public function __construct()
    {
        $this->showInstall();
        $this->checkMigrateStatus();
        $this->settings = CompanySetting::first();
        $this->smsSettings = SmsSetting::first();

        config(['app.name' => $this->settings->company_name]);
        config(['app.url' => url('/')]);

        if (request()->hasCookie('language_code')) {
            App::setLocale(decrypt(request()->cookie('language_code'), false));
        }
        else {
            App::setLocale($this->settings->locale);
        }

        $this->themeSettings = ThemeSetting::first();
        $this->languages = Language::where('status', 'enabled')->orderBy('language_name', 'asc')->get();
        $this->frontThemeSettings = FrontThemeSetting::first();
        $this->locations = Location::select('id', 'name')->get();
        $this->pages = Page::all();

        view()->share('settings', $this->settings);
        view()->share('smsSettings', $this->smsSettings);
        view()->share('themeSettings', $this->themeSettings);
        view()->share('languages', $this->languages);
        view()->share('frontThemeSettings', $this->frontThemeSettings);
        view()->share('locations', $this->locations);
        view()->share('pages', $this->pages);
        view()->share('calling_codes', $this->getCallingCodes());
        view()->share('date_picker_format', Formats::dateFormats()[$this->settings->date_format]);
        view()->share('time_picker_format', Formats::timeFormats()[$this->settings->time_format]);

        $this->middleware('auth')->only(['paymentGateway', 'offlinePayment', 'paymentConfirmation']);

        $this->middleware(function ($request, $next) {
            $this->productsCount = request()->hasCookie('products') ? sizeof(json_decode(request()->cookie('products'), true)) : 0;
            $this->user = auth()->user();
            if ($this->user) {
                config(['froiden_envato.allow_users_id' => true]);
            }
            view()->share('user', $this->user);
            view()->share('productsCount', $this->productsCount);
            return $next($request);
        });
    }

    public function checkMigrateStatus()
    {
        $status = Artisan::call('migrate:check');
        if ($status) {
            Artisan::call('migrate', array('--force' => true)); //migrate database
        }
    }

    public function getCallingCodes()
    {
        $codes = [];
        foreach(config('calling_codes.codes') as $code) {
            $codes = array_add($codes, $code['code'], array('name' => $code['name'], 'dial_code' => $code['dial_code']));
        };
        return $codes;
    }
}
