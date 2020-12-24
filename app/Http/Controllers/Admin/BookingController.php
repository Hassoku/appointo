<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingItem;
use App\BusinessService;
use App\CompanySetting;
use App\EmployeeGroup;
use App\Helper\Reply;
use App\Location;
use App\Notifications\BookingCancel;
use App\Notifications\BookingReminder;
use App\TaxSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\BookingStatusMultiUpdate;
use App\Http\Requests\Booking\UpdateBooking;
use App\Payment;
use App\PaymentGatewayCredentials;

class BookingController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $credentials = PaymentGatewayCredentials::first();
        $setting = CompanySetting::with('currency')->first();

        view()->share('pageTitle', __('menu.bookings'));
        view()->share('credentials', $credentials);
        view()->share('setting', $setting);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking') && !$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        if(\request()->ajax()){
            $bookings = Booking::orderBy('date_time', 'desc');

            if(\request('filter_status') != ""){
                $bookings->where('bookings.status', \request('filter_status'));
            }

            if(\request('filter_customer') != ""){
                $bookings->where('bookings.user_id', \request('filter_customer'));
            }

            if(\request('filter_location') != ""){
                $bookings->leftJoin('booking_items', 'bookings.id', 'booking_items.booking_id')
                    ->leftJoin('business_services', 'booking_items.business_service_id', 'business_services.id')
                    ->leftJoin('locations', 'business_services.location_id', 'locations.id')
                    ->select('bookings.*')
                    ->where('locations.id', request('filter_location'))
                    ->groupBy('bookings.id');
            }

            if(\request('filter_date') != ""){
                $startTime = Carbon::createFromFormat($this->settings->date_format, request('filter_date'), $this->settings->timezone)->setTimezone('UTC')->startOfDay();
                $endTime = $startTime->copy()->addDay()->subSecond();

                $bookings->whereBetween('bookings.date_time', [$startTime, $endTime]);
            }

            if(!$this->user->is_admin && !$this->user->can('create_point_of_sale')){
                ($this->user->is_employee) ? $bookings->where('bookings.employee_id', $this->user->id) : $bookings->where('bookings.user_id', $this->user->id);
            }

            $bookings->get();

            return \datatables()->of($bookings)
                ->editColumn('id', function ($row) {
                    $view = view('admin.booking.list_view', compact('row'))->render();
                    return $view;
                })
                ->rawColumns(['id'])
                ->toJson();
        }

        $customers = User::all();
        $locations = Location::all();
        $status = \request('status');

        return view('admin.booking.index', compact('customers', 'status', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking') && !$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale'), 403);

        $booking = Booking::with('employee')->find($id);
        $frontThemeSetting = $this->frontThemeSettings;
        $view = view('admin.booking.show', compact('booking', 'frontThemeSetting'))->render();

        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        abort_if(!$this->user->can('update_booking'), 403);

        $tax = TaxSetting::active()->first();
        $employees = User::allEmployees()->get();
        $businessServices = BusinessService::active()->get();
        $view = view('admin.booking.edit', compact('booking', 'tax', 'businessServices', 'employees'))->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBooking $request, $id)
    {
        abort_if(!$this->user->can('update_booking'), 403);

        //delete old items and enter new
        BookingItem::where('booking_id', $id)->delete();

        $services = $request->cart_services;
        $quantity = $request->cart_quantity;
        $prices = $request->cart_prices;
        $discount = $request->cart_discount;
        $payment_status = $request->payment_status;
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


        $booking = Booking::find($id);

        $taxAmount = 0;
        if($booking->tax_name){
            $taxAmount = $originalAmount * $booking->tax_percent / 100;
            $booking->tax_amount = $taxAmount;
        }

        if($discount > 0){
            if($discount > 100) $discount = 100;

            $discountAmount = (($discount/100) * $originalAmount);
        }

        $amountToPay = ($originalAmount - $discountAmount + $taxAmount);
        $amountToPay = round($amountToPay, 2);

        $booking->date_time   = Carbon::createFromFormat($this->settings->date_format . ' ' . $this->settings->time_format, $request->booking_date . ' ' . $request->booking_time)->format('Y-m-d H:i:s');
        $booking->status      = $request->status;
        $booking->employee_id = ($request->employee_id != '') ? $request->employee_id : null ;
        $booking->original_amount = $originalAmount;
        $booking->discount = $discountAmount;
        $booking->discount_percent = $request->cart_discount;;
        $booking->amount_to_pay = $amountToPay;
        $booking->payment_status = $payment_status;

        $booking->save();

        $total_amount = 0.00;
        foreach ($bookingItems as $key=>$bookingItem){
            $bookingItems[$key]['booking_id'] = $booking->id;
            $total_amount += $bookingItem['amount'];
        }
        $total_amount = round($total_amount, 2);

        if (!$booking->payment) {
            $payment = new Payment();

            $payment->currency_id = $this->settings->currency_id;
            $payment->booking_id = $booking->id;
            $payment->amount = $total_amount;
            $payment->gateway = 'cash';
            $payment->status = 'completed';
            $payment->paid_on = Carbon::now();
        }
        else {
            $payment = $booking->payment;
            $payment->status = $payment_status;
            $payment->amount = $total_amount;
        }

        $payment->save();

        DB::table('booking_items')->insert($bookingItems);

        $view = view('admin.booking.show', compact('booking'))->render();

        return Reply::successWithData('messages.updatedSuccessfully', ['status' => 'success', 'view' => $view]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_booking'), 403);

        Booking::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

    public function download($id) {

        $booking = Booking::findOrFail($id);

        if($booking->status != 'completed'){
            abort(403);
        }

        if($this->user->is_admin || $booking->user_id == $this->user->id){
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('admin.booking.receipt',compact('booking') );
            $filename = __('app.receipt').' #'.$booking->id;
//       return $pdf->stream();
            return $pdf->download($filename . '.pdf');
        }
        else{
            abort(403);
        }
    }

    public function requestCancel($id){
        $booking = Booking::findOrFail($id);
        $booking->status = 'canceled';
        $booking->save();

        $tax = TaxSetting::first();
        $view = view('admin.booking.show', compact('booking', 'tax'))->render();

        $admins = User::allAdministrators()->get();

        Notification::send($admins, new BookingCancel($booking));

        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function sendReminder(){
        $bookingId = \request('bookingId');
        $booking = Booking::findOrFail($bookingId);
        $customer = User::findOrFail($booking->user_id);
        $customer->notify(new BookingReminder($booking));

        return Reply::success(__('messages.bookingReminderSent'));
    }

    public function multiStatusUpdate(BookingStatusMultiUpdate $request) {
        Booking::whereIn('id', $request->booking_checkboxes)->update([
            'status' => $request->change_status
        ]);

        // $bookings = Booking::find($request->booking_checkboxes);
        // $bookings->map(function ($booking, $key) use ($request){
        //     $booking->status = $request->change_status;
        // });

        return Reply::dataOnly(['status' => 'success', '']);
    }

}
