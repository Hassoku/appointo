<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingItem;
use App\BusinessService;
use App\Category;
use App\Helper\Reply;
use App\Http\Requests\Pos\StorePos;
use App\Location;
use App\TaxSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.pos'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        $services = BusinessService::active()->get();
        $categories = Category::active()
            ->with(['services' => function ($query) {
                $query->active();
            }])->get();
        $locations = Location::all();
        $tax = TaxSetting::active()->first();

        return view('admin.pos.create', compact('services', 'categories', 'locations', 'tax'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePos $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        $dateTime = Carbon::createFromFormat($this->settings->date_format.' '.$this->settings->time_format, $request->date.' '.$request->time)->format('Y-m-d H:i:s');
        $dateTimestamp = Carbon::createFromFormat($this->settings->date_format.' '.$this->settings->time_format, $request->date.' '.$request->time)->format('Y-m-d H:i:s');
        $currentTime = Carbon::now()->timezone($this->settings->timezone)->format('Y-m-d H:i:s');

        // edited at is newer than created at
        $tax = TaxSetting::active()->first();
        $services = $request->cart_services;
        $quantity = $request->cart_quantity;
        $prices = $request->cart_prices;
        $discount = $request->cart_discount;
        $taxAmount = 0;
        $discountAmount = 0;
        $amountToPay = 0;

        $originalAmount = 0;
        $bookingItems = array();

        foreach ($services as $key=>$service){
            $amount = ($quantity[$key] * $prices[$key]);

            $bookingItems[] = [
                "business_service_id" => $service,
                "quantity" => $quantity[$key],
                "unit_price" => $prices[$key],
                "amount" => $amount
            ];

            $originalAmount = ($originalAmount + $amount);
        }


        if(!is_null($tax) && $tax->percent > 0){
            $taxAmount = (($tax->percent/100) * $originalAmount);
        }

        if($discount > 0){
            if($discount > 100) $discount = 100;

            $discountAmount = (($discount/100) * $originalAmount);
        }

        $amountToPay = ($originalAmount - $discountAmount + $taxAmount);
        $amountToPay = round($amountToPay, 2);


        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->date_time = $dateTime;
        $booking->status = (strtotime($dateTimestamp) < strtotime($currentTime)) ? 'completed' : 'pending';
        $booking->payment_gateway = $request->payment_gateway;
        $booking->original_amount = $originalAmount;
        $booking->discount = $discountAmount;
        $booking->discount_percent = $request->cart_discount;
        $booking->payment_status = 'completed';

        if(!is_null($tax)) {
            $booking->tax_name = $tax->tax_name;
            $booking->tax_percent = $tax->percent;
            $booking->tax_amount = $taxAmount;
        }

        $booking->amount_to_pay = $amountToPay;
        $booking->save();


        foreach ($bookingItems as $key=>$bookingItem){
            $bookingItems[$key]['booking_id'] = $booking->id;
        }

        DB::table('booking_items')->insert($bookingItems);

        // create payment
        $payment = new Payment();

        $payment->currency_id = $this->settings->currency_id;
        $payment->booking_id = $booking->id;
        $payment->amount = $booking->amount_to_pay;
        $payment->gateway = $booking->payment_gateway;
        $payment->status = $booking->payment_status;
        $payment->paid_on = $booking->utc_date_time;

        $payment->save();

        return Reply::redirect(route('admin.bookings.index'), __('messages.createdSuccessfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function selectCustomer(){
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        return view('admin.pos.select_customer');
    }

    public function searchCustomer(Request $request){
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        $searchTerm = $request->q;
        $users = User::where('name', 'like', $searchTerm.'%')
            ->orWhere('mobile', 'like', '%'.$searchTerm.'%')
            ->orWhere('email', 'like', '%'.$searchTerm.'%')
            ->get();

        $items = [];
        foreach ($users as $user){
            $items[] = ['id'=>$user->id, 'full_name' => $user->name, 'email' => $user->email, 'mobile' => $user->formatted_mobile];
        }

        $json = [
            'total_count' => count($users),
            'incomplete_results' => false,
            'items' => $items
        ];

        return json_encode($json);
//        return view('admin.pos.select_customer');
    }

    public function addCart(){

    }

    public function filterServices(Request $request) {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        if ($request->category_id !== '0') {
            $categories = Category::where('id', $request->category_id)
                ->active()
                ->with([
                    'services' => function($query) use($request) {
                        if ($request->location_id !== '0') {
                            $query->active()->where('location_id', $request->location_id);
                        }
                        else {
                            $query->active();
                        }
                    }
                ])->get();
        }
        else {
            $categories = Category::active()
                ->with([
                    'services' => function($query) use($request) {
                        if ($request->location_id !== '0') {
                            $query->active()->where('location_id', $request->location_id);
                        }
                        else {
                            $query->active();
                        }
                    }
                ])->get();
        }

        $view = view('admin.pos.filtered_services', compact('categories'))->render();

        return Reply::dataOnly(['view' => $view]);
    }
}
