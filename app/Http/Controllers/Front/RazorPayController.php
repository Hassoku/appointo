<?php
namespace App\Http\Controllers\Front;

use App\Booking;
use App\CompanySetting;
use App\Currency;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Notifications\BookingConfirmation;
use App\Notifications\NewBooking;
use App\Payment;
use App\PaymentGatewayCredentials;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Razorpay\Api\Api;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class RazorPayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $razorPayCredentials = PaymentGatewayCredentials::first();

        /** setup RazorPay credentials **/
        $this->api = new Api($razorPayCredentials->razorpay_key, $razorPayCredentials->razorpay_secret);
        $this->pageTitle = 'RazorPay';
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentWithRazorPay(Request $request)
    {
        $bookingId = $request->booking_id;
        $paymentId = $request->payment_id;
        $response = $request->response;

        $booking = Booking::where(['id' => $bookingId, 'user_id' => $this->user->id])->first();
        $payment = $this->api->payment->fetch($paymentId);

        $amount = $booking->amount_to_pay * 100;

        if ($amount == $payment->amount && $payment->status == 'authorized') {
            $currency = $this->settings->currency;

            $razorpay_response = $payment->capture([
                'amount' => $payment->amount,
                'currency' => $currency->currency_code
            ]);

            if ($razorpay_response->error_code) {
                return Reply::error($razorpay_response->error_description);
            }

            // create payment
            $payment = new Payment();

            $payment->booking_id = $booking->id;
            $payment->currency_id = $currency->id;
            $payment->amount = $booking->amount_to_pay;
            $payment->gateway = 'RazorPay';
            $payment->transaction_id = $paymentId;
            $payment->paid_on = Carbon::now();
            $payment->status = 'completed';

            $payment->save();

            // update booking
            $booking->payment_gateway = 'RazorPay';
            $booking->save();

            // send email notifications
            $admins = User::allAdministrators()->get();
            Notification::send($admins, new NewBooking($booking));

            $user = User::findOrFail($booking->user_id);
            $user->notify(new BookingConfirmation($booking));

            \Session::put('success',__('messages.paymentSuccessAmount') .$currency->currency_symbol.$booking->amount_to_pay);

            return Reply::redirect(route('front.payment', $bookingId), 'Payment success');
        }
    }
}
