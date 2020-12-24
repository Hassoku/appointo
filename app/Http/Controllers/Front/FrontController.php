<?php

namespace App\Http\Controllers\Front;

use App\Booking;
use App\BookingTime;
use App\BusinessService;
use App\Category;
use App\CompanySetting;
use App\Helper\Reply;
use App\Http\Requests\Front\CartPageRequest;
use App\Http\Requests\StoreFrontBooking;
use App\Location;
use App\Media;
use App\Notifications\BookingConfirmation;
use App\Notifications\NewBooking;
use App\Notifications\NewUser;
use App\PaymentGatewayCredentials;
use App\TaxSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ContactRequest;
use App\Language;
use App\Notifications\NewContact;
use App\Page;
use App\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class FrontController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (request()->ajax()) {
            $location = Location::where('name', request()->location)->first();

            $categories = Category::active()
                ->with([
                    'services' => function ($query) use ($location) {
                        if ($location !== null) {
                            $query->active()->where('location_id', $location->id);
                        } else {
                            $query->active();
                        }
                    }
                ])
                ->get();


            $services = BusinessService::active()->with('category');

            if ($location !== null) {
                $services = $services->where('location_id', $location->id);
            }

            $services = $services->get();

            return Reply::dataOnly(['categories' => $categories, 'services' => $services]);
        } else {
            $categories = Category::active()->with(['services' => function ($query) {
                $query->active();
            }])->get();
            $services = BusinessService::active()->get();
        }

        $images = Media::select('id', 'file_name')->latest()->get();

        return view('front.index', compact('categories', 'services', 'images'));
    }

    public function addOrUpdateProduct(Request $request)
    {
        $newProduct = [
            "servicePrice" => $request->servicePrice,
            "serviceName" => $request->serviceName
        ];

        $products = [];
        $serviceQuantity = $request->serviceQuantity ?? 1;

        if (!$request->hasCookie('products')) {
            $newProduct = Arr::add($newProduct, 'serviceQuantity', $serviceQuantity);
            $products = Arr::add($products, $request->serviceId, $newProduct);

            return response([
                'status' => 'success',
                'message' => __('messages.front.success.productAddedToCart'),
                'productsCount' => sizeof($products)
            ])->cookie('products', json_encode($products));
        }

        $products = json_decode($request->cookie('products'), true);

        if (!array_key_exists($request->serviceId, $products)) {
            $newProduct = Arr::add($newProduct, 'serviceQuantity', $serviceQuantity);
            $products = Arr::add($products, $request->serviceId, $newProduct);

            return response([
                'status' => 'success',
                'message' => __('messages.front.success.productAddedToCart'),
                'productsCount' => sizeof($products)
            ])->cookie('products', json_encode($products));
        } else {
            if ($request->serviceQuantity) {
                $products[$request->serviceId]['serviceQuantity'] = $request->serviceQuantity;
            } else {
                $products[$request->serviceId]['serviceQuantity'] += 1;
            }
        }


        return response([
            'status' => 'success',
            'message' => __('messages.front.success.cartUpdated'),
            'productsCount' => sizeof($products)
        ])->cookie('products', json_encode($products));
    }

    public function bookingPage(Request $request)
    {
        $bookingDetails = [];

        if ($request->hasCookie('bookingDetails')) {
            $bookingDetails = json_decode($request->cookie('bookingDetails'), true);
        }

        if ($request->ajax()) {
            return Reply::dataOnly(['status' => 'success', 'productsCount' => $this->productsCount]);
        }

        return view('front.booking_page', compact('bookingDetails'));
    }

    public function addBookingDetails(CartPageRequest $request)
    {
        $expireTime = Carbon::parse($request->bookingDate . ' ' . $request->bookingTime, $this->settings->timezone);
        $cookieTime = Carbon::now()->setTimezone($this->settings->timezone)->diffInMinutes($expireTime);

        return response(Reply::dataOnly(['status' => 'success']))->cookie('bookingDetails', json_encode(['bookingDate' => $request->bookingDate, 'bookingTime' => $request->bookingTime]), $cookieTime);
    }

    public function cartPage(Request $request)
    {
        $products = json_decode($request->cookie('products'), true);
        $bookingDetails = json_decode($request->cookie('bookingDetails'), true);
        $tax = TaxSetting::active()->first();

        return view('front.cart_page', compact('products', 'bookingDetails', 'tax'));
    }

    public function deleteProduct(Request $request, $id)
    {
        $products = json_decode($request->cookie('products'), true);

        if ($id != 'all') {
            Arr::forget($products, $id);
        } else {
            return response(Reply::successWithData(__('messages.front.success.cartCleared'), ['action' => 'redirect', 'url' => route('front.cartPage'), 'productsCount' => sizeof($products)]))->withCookie(Cookie::forget('bookingDetails'))->withCookie(Cookie::forget('products'));
        }

        if (sizeof($products) > 0) {
            return response(Reply::successWithData(__('messages.front.success.productDeleted'), ['productsCount' => sizeof($products)]))->cookie('products', json_encode($products));
        }

        return response(Reply::successWithData(__('messages.front.success.cartCleared'), ['action' => 'redirect', 'url' => route('front.cartPage'), 'productsCount' => sizeof($products)]))->withCookie(Cookie::forget('bookingDetails'))->withCookie(Cookie::forget('products'));
    }

    public function updateCart(Request $request)
    {
        return response(Reply::success(__('messages.front.success.cartUpdated')))->cookie('products', json_encode($request->products));
    }

    public function checkoutPage()
    {
        $bookingDetails = request()->hasCookie('bookingDetails') ? json_decode(request()->cookie('bookingDetails'), true) : [];
        $totalAmount = array_reduce(json_decode(request()->cookie('products'), true), function ($sum, $item) {
            $sum += $item['servicePrice'] * $item['serviceQuantity'];
            return $sum;
        }, 0);
        $tax = TaxSetting::active()->first();

        if ($tax) {
            $totalAmount += ($tax->percent / 100) * $totalAmount;
        }

        $totalAmount = round($totalAmount, 2);
        return view('front.checkout_page', compact('totalAmount', 'bookingDetails'));
    }

    public function paymentFail(Request $request, $bookingId = null)
    {
        $credentials = PaymentGatewayCredentials::first();
        if ($bookingId == null) {
            $booking = Booking::where([
                'user_id' => $this->user->id
            ])
                ->latest()
                ->first();
        } else {
            $booking = Booking::where(['id' => $bookingId, 'user_id' => $this->user->id])->first();
        }

        $setting = CompanySetting::with('currency')->first();
        $user = $this->user;

        return view('front.payment', compact('credentials', 'booking', 'user', 'setting'));
    }

    public function paymentSuccess(Request $request, $bookingId = null)
    {
        $credentials = PaymentGatewayCredentials::first();
        if ($bookingId == null) {
            $booking = Booking::where([
                'user_id' => $this->user->id
            ])
                ->latest()
                ->first();
        } else {
            $booking = Booking::where(['id' => $bookingId, 'user_id' => $this->user->id])->first();
        }

        $setting = CompanySetting::with('currency')->first();
        $user = $this->user;

        if ($booking->payment_status !== 'completed'){
            $booking->payment_status = 'completed';
            $booking->save();
        }

        return view('front.payment', compact('credentials', 'booking', 'user', 'setting'));
    }

    public function paymentGateway(Request $request)
    {
        $credentials = PaymentGatewayCredentials::first();
        $booking = Booking::where([
            'user_id' => $this->user->id
        ])
            ->latest()
            ->first();

        $setting = CompanySetting::with('currency')->first();
        $frontThemeSetting = $this->frontThemeSettings;
        $user = $this->user;

        if ($booking->payment_status == 'completed') {
            return redirect(route('front.index'));
        }

        return view('front.payment-gateway', compact('credentials', 'booking', 'user', 'setting', 'frontThemeSetting'));
    }

    public function offlinePayment($bookingId = null)
    {
        if ($bookingId == null) {
            $booking = Booking::where([
                'user_id' => $this->user->id
            ])
                ->latest()
                ->first();
        } else {
            $booking = Booking::where(['id' => $bookingId, 'user_id' => $this->user->id])->first();
        }

        if (!$booking || $booking->payment_status == 'completed') {
            return redirect()->route('front.index');
        }

        $booking->payment_status = 'pending';
        $booking->save();

        $admins = User::allAdministrators()->get();

        Notification::send($admins, new NewBooking($booking));
        $user = User::findOrFail($booking->user_id);
        $user->notify(new BookingConfirmation($booking));

        return view('front.booking_success');
    }

    public function bookingSlots(Request $request)
    {
        $bookingDate = Carbon::createFromFormat('m/d/Y', $request->bookingDate);
        $day = $bookingDate->format('l');
        $bookingTime = BookingTime::where('day', strtolower($day))->first();

        //check if multiple booking allowed
        $bookings = Booking::select('id', 'date_time')->where(DB::raw('DATE(date_time)'), $bookingDate->format('Y-m-d'));
        if ($bookingTime->multiple_booking == 'no') {
            $bookings = $bookings->get();
        }
        else {
            $bookings = $bookings->whereRaw('DAYOFWEEK(date_time) = '.($bookingDate->dayOfWeek + 1))->get();
        }

        $variables = compact('bookingTime', 'bookings');

        if ($bookingTime->status == 'enabled') {
            if ($bookingDate->day == Carbon::today()->day) {
                $startTime = Carbon::createFromFormat($this->settings->time_format, $bookingTime->utc_start_time);
                while ($startTime->lessThanOrEqualTo(Carbon::now())) {
                    $startTime = $startTime->addMinutes($bookingTime->slot_duration);
                }
            } else {
                $startTime = Carbon::createFromFormat($this->settings->time_format, $bookingTime->utc_start_time);
            }
            $endTime = Carbon::createFromFormat($this->settings->time_format, $bookingTime->utc_end_time);

            $startTime->setTimezone($this->settings->timezone);
            $endTime->setTimezone($this->settings->timezone);

            $startTime->setDate($bookingDate->year, $bookingDate->month, $bookingDate->day);
            $endTime->setDate($bookingDate->year, $bookingDate->month, $bookingDate->day);
            
            $variables = compact('startTime', 'endTime', 'bookingTime', 'bookings');
        }
        $view = view('front.booking_slots', $variables)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function saveBooking(StoreFrontBooking $request)
    {
        if ($this->user) {
            $user = $this->user;
        } else {
            $user = User::firstOrNew(['email' => $request->email]);
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->mobile = $request->phone;
            $user->calling_code = $request->calling_code;
            $user->password = '123456';
            $user->save();

            $user->attachRole(Role::where('name', 'customer')->withoutGlobalScopes()->first()->id);

            Auth::loginUsingId($user->id);
            $this->user = $user;

            if ($this->smsSettings->nexmo_status == 'active' && !$user->mobile_verified) {
                // verify user mobile number
                return response(Reply::redirect(route('front.checkoutPage'), __('messages.front.success.userCreated')));
            }

            $user->notify(new NewUser('123456'));
        }

        // get products and bookingDetails
        $products = json_decode($request->cookie('products'), true);
        $bookingDetails = json_decode($request->cookie('bookingDetails'), true);

        // get bookings and bookingTime as per bookingDetails date
        $bookingDate = Carbon::createFromFormat('m/d/Y', $bookingDetails['bookingDate']);
        $day = $bookingDate->format('l');
        $bookingTime = BookingTime::where('day', strtolower($day))->first();

        $bookings = Booking::select('id', 'date_time')->where(DB::raw('DATE(date_time)'), $bookingDate->format('Y-m-d'))->whereRaw('DAYOFWEEK(date_time) = '.($bookingDate->dayOfWeek + 1))->get();

        if ($bookings->count() >= $bookingTime->max_booking &&  $bookingTime->max_booking != 0) {
            return response(Reply::redirect(route('front.bookingPage')))->withCookie(Cookie::forget('bookingDetails'));
        }

        $tax = TaxSetting::active()->first();
        $originalAmount = $taxAmount = $amountToPay = $discountAmount = 0;

        $bookingItems = array();

        foreach ($products as $key => $product) {
            $amount = ($product['serviceQuantity'] * $product['servicePrice']);

            $bookingItems[] = [
                "business_service_id" => $key,
                "quantity" => $product['serviceQuantity'],
                "unit_price" => $product['servicePrice'],
                "amount" => $amount
            ];

            $originalAmount = ($originalAmount + $amount);
        }

        if (!is_null($tax) && $tax->percent > 0) {
            $taxAmount = (($tax->percent / 100) * $originalAmount);
        }

        $amountToPay = ($originalAmount + $taxAmount);
        $amountToPay = round($amountToPay, 2);

        $booking = new Booking();
        $booking->user_id = $user->id;
        $booking->date_time = Carbon::createFromFormat('m/d/Y', $bookingDetails['bookingDate'])->format('Y-m-d') . ' ' . Carbon::createFromFormat('H:i:s', $bookingDetails['bookingTime'])->format('H:i:s');
        $booking->status = 'pending';
        $booking->payment_gateway = 'cash';
        $booking->original_amount = $originalAmount;
        $booking->discount = $discountAmount;
        $booking->discount_percent = '0';
        $booking->payment_status = 'pending';
        $booking->additional_notes = $request->additional_notes;
        $booking->source = 'online';
        if (!is_null($tax)) {
            $booking->tax_name = $tax->tax_name;
            $booking->tax_percent = $tax->percent;
            $booking->tax_amount = $taxAmount;
        }
        $booking->amount_to_pay = $amountToPay;
        $booking->save();


        foreach ($bookingItems as $key => $bookingItem) {
            $bookingItems[$key]['booking_id'] = $booking->id;
        }

        DB::table('booking_items')->insert($bookingItems);

        return response(Reply::redirect(route('front.payment-gateway'), __('messages.front.success.bookingCreated')))->withCookie(Cookie::forget('bookingDetails'))->withCookie(Cookie::forget('products'));
    }

    public function searchServices(Request $request)
    {
        $services = [];
        if ($request->search_term !== null) {
            $location = Location::where('name', request()->location)->first();

            $categories = Category::active()
                ->where('name', 'LIKE', '%' . strtolower($request->search_term) . '%')
                ->with(['services' => function ($q) use ($location) {
                    if ($location !== null) {
                        $q->active()->where('location_id', $location->id);
                    } else {
                        $q->active();
                    }
                }])->get();
            if ($categories->count() > 0) {
                foreach ($categories as $category) {
                    foreach ($category->services as $service) {
                        $services[] = $service;
                    }
                }
            }

            if ($location !== null) {
                $filteredServices = BusinessService::active()->where('name', 'LIKE', '%' . strtolower($request->search_term) . '%')->where('location_id', $location->id)->get();
            } else {
                $filteredServices = BusinessService::active()->where('name', 'LIKE', '%' . strtolower($request->search_term) . '%')->get();
            }

            foreach ($filteredServices as $service) {
                $services[] = $service;
            }

            $services = collect(array_unique($services));
        } else {
            $services = collect($services);
        }

        return view('front.search_page', compact('services'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('front.page', compact('page'));
    }

    public function contact(ContactRequest $request)
    {
        $users = User::select('id', 'email', 'name')->allAdministrators()->get();
        Notification::send($users, new NewContact());
        return Reply::success(__('messages.front.success.emailSent'));
    }

    public function serviceDetail(Request $request, $categorySlug, $serviceSlug)
    {
        $service = BusinessService::where('slug', $serviceSlug)->first();

        $products = json_decode($request->cookie('products'), true) ?: [];
        $reqProduct = array_filter($products, function ($product) use ($service) {
            return $product['serviceName'] == $service->name;
        });

        return view('front.service_detail', compact('service', 'reqProduct'));
    }

    public function changeLanguage($code)
    {
        $language = Language::where('language_code', $code)->first();

        if (!$language) {
            return Reply::error('invalid language code');
        }

        return response(Reply::success(__('messages.languageChangedSuccessfully')))->cookie('language_code', $code);
    }
}
