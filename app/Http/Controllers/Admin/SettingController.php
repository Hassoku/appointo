<?php

namespace App\Http\Controllers\Admin;

use App\BookingTime;
use App\CompanySetting;
use App\Currency;
use App\FrontThemeSetting;
use App\Helper\Formats;
use App\Helper\Files;
use App\Helper\Reply;
use App\Language;
use App\Media;
use App\PaymentGatewayCredentials;
use App\SmtpSetting;
use App\TaxSetting;
use App\ThemeSetting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSetting;
use App\Module;
use App\Permission;
use App\Role;
use App\SmsSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.settings'));

    }

    public function index(){
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('manage_settings'), 403);

        $bookingTimes = BookingTime::all();
        $images = Media::select('id', 'file_name')->latest()->get();
        $tax = TaxSetting::first();
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $dateFormats = Formats::dateFormats();
        $timeFormats = Formats::timeFormats();
        $dateObject = Carbon::now($this->settings->timezone);
        $currencies = Currency::all();
        $enabledLanguages = Language::where('status', 'enabled')->orderBy('language_name')->get();
        $smtpSetting = SmtpSetting::first();
        $themeSetting = ThemeSetting::first();
        $frontThemeSetting = FrontThemeSetting::first();
        $credentialSetting = PaymentGatewayCredentials::first();
        $smsSetting = SmsSetting::first();
        $roles = Role::where('name', '<>', 'administrator')->get();
        $totalPermissions = Permission::count();
        $modules = Module::all();

        $client = new Client();
        $res = $client->request('GET', config('froiden_envato.updater_file_path'), ['verify' => false]);
        $lastVersion = $res->getBody();
        $lastVersion = json_decode($lastVersion, true);
        $currentVersion = File::get('version.txt');

        $description = $lastVersion['description'];

        $newUpdate = 0;
        if (version_compare($lastVersion['version'], $currentVersion) > 0)
        {
            $newUpdate = 1;
        }
        $updateInfo = $description;
        $lastVersion = $lastVersion['version'];

        $appVersion = File::get('version.txt');
        $laravel = app();
        $laravelVersion = $laravel::VERSION;

        return view('admin.settings.index', compact('bookingTimes', 'images', 'tax', 'timezones', 'dateFormats', 'timeFormats', 'dateObject', 'currencies', 'enabledLanguages', 'smtpSetting', 'themeSetting', 'frontThemeSetting', 'lastVersion', 'updateInfo', 'appVersion', 'laravelVersion', 'newUpdate', 'credentialSetting', 'smsSetting', 'roles', 'totalPermissions', 'modules'));
    }

    public function update(UpdateSetting $request, $id){
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('manage_settings'), 403);

        $setting = CompanySetting::first();
        $setting->company_name = $request->company_name;
        $setting->company_email = $request->company_email;
        $setting->company_phone = $request->company_phone;
        $setting->address = $request->address;
        $setting->date_format = $request->date_format;
        $setting->time_format = $request->time_format;
        $setting->website = $request->website;
        $setting->timezone = $request->timezone;
        $setting->locale = $request->input('locale');
        $setting->currency_id = $request->currency_id;
        if ($request->hasFile('logo')) {
            $setting->logo = Files::upload($request->logo,'logo');
        }
        $setting->save();

        if ($setting->currency->currency_code !== 'INR') {
            $credential = PaymentGatewayCredentials::first();

            if ($credential->razorpay_status == 'active') {
                $credential->razorpay_status = 'deactive';

                $credential->save();
            }
        }
        return Reply::redirect(route('admin.settings.index'), __('messages.updatedSuccessfully'));
    }
}
