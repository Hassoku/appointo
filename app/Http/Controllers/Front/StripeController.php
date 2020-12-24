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
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $stripeCredentials = PaymentGatewayCredentials::first();

        /** setup Stripe credentials **/
        Stripe::setApiKey($stripeCredentials->stripe_secret);
        $this->pageTitle = 'Stripe';
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentWithStripe(Request $request, $bookingId = null)
    {
        if ($bookingId == null) {
            $invoice = Booking::where([
                            'user_id' => $this->user->id
                        ])
                        ->latest()
                        ->first();
        } else {
            $invoice = Booking::where(['id' => $bookingId, 'user_id' => $this->user->id])->first();
        }

        $setting = CompanySetting::with('currency')->first();
        $currency = $setting->currency;
        $tokenObject  = $request->get('token');
        $token  = $tokenObject['id'];
        $email  = $tokenObject['email'];
            try {
                $customer = Customer::create(array(
                    'email' => $email,
                    'source'  => $token
                ));

                $charge = Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $invoice->amount_to_pay*100,
                    'currency' => $currency->currency_code
                ));

            } catch (\Exception $ex) {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return $this->redirectToErrorPage($bookingId, 'Payment fail');
            }

            $payment = new Payment();
            $payment->booking_id = $invoice->id;
            $payment->currency_id = $currency->id;
            $payment->amount = $invoice->amount_to_pay;
            $payment->gateway = 'Stripe';
            $payment->transaction_id = $charge->id;
            $payment->paid_on = Carbon::now();
            $payment->status = 'completed';
            $payment->save();

        $invoice->payment_gateway = 'Stripe';
        $invoice->save();

//            send email notifications
        $admins = User::allAdministrators()->get();
        Notification::send($admins, new NewBooking($invoice));

        $user = User::findOrFail($invoice->user_id);
        $user->notify(new BookingConfirmation($invoice));

        \Session::put('success',__('messages.paymentSuccessAmount') .$currency->currency_symbol.$invoice->amount_to_pay);

        return $this->redirectToPayment($bookingId, 'Payment success');
    }

    public function redirectToPayment($id, $message) {
        if ($id == null) {
            return Reply::redirect(route('front.payment.success'), $message);
        }
        return Reply::redirect(route('front.payment.success', $id), $message);
    }

    public function redirectToErrorPage($id, $message) {
        if ($id == null) {
            return Reply::redirect(route('front.payment.fail'), $message);
        }
        return Reply::redirect(route('front.payment.fail', $id), $message);
    }
}
