<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Reply;
use App\Booking;
use App\BusinessService;
use Illuminate\Support\Facades\DB;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.reports'));
    }

    public function index() {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report'), 403);

        return view('admin.report.layout');
    }

    public function earningReportChart(Request $request) {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report'), 403);

        $payments = Payment::where('status', 'completed')
            ->whereDate('paid_on', '>=', Carbon::createFromFormat($this->settings->date_format, $request->startDate))
            ->whereDate('paid_on', '<=', Carbon::createFromFormat($this->settings->date_format, $request->endDate))
            ->groupBy('year', 'month')
            ->orderBy('amount', 'ASC')
            ->get(
                [
                    DB::raw('DATE_FORMAT(paid_on,"%D-%M-%Y") as pay_date'),
                    DB::raw('DATE_FORMAT(paid_on,"%M/%y") as date'),
                    DB::raw('YEAR(paid_on) year, MONTH(paid_on) month'),
                    DB::raw('sum(amount) as total')
                ]
            );

        $graphData = [];
            foreach($payments as $key2=>$payment){
                $payments[$key2]->total = $payment->total;
                $graphData[] = $payment;
            }

        usort(
            $graphData, function ($a, $b) {
                $t1 = strtotime($a->pay_date);
                $t2 = strtotime($b->pay_date);
                return $t1 - $t2;
            }
        );

        $labels = [];
        foreach($graphData as $gData){
            $labels[] = $gData->date;
        }

        $earnings = [];
        foreach($graphData as $gData){
            $earnings[] = round($gData->total, 2);
        }

        return Reply::dataOnly(['labels' => $labels, 'data' => $earnings, 'status' => 'success']);
    }

    public function earningTable(Request $request){
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report'), 403);

        $bookings = Booking::where('payment_status', 'completed')
            ->with('payment')
            ->whereHas('payment', function ($query) use ($request) {
                $query->whereDate('paid_on', '>=', Carbon::createFromFormat($this->settings->date_format, $request->startDate))
                ->whereDate('paid_on', '<=', Carbon::createFromFormat($this->settings->date_format, $request->endDate));
            })
            ->get();

        return \datatables()->of($bookings)
            ->editColumn('user_id', function ($row) {
                return ucwords($row->user->name);
            })
            ->editColumn('amount_to_pay', function ($row) {
                return number_format((float)$row->amount_to_pay, 2, '.', '');
            })
            ->editColumn('date_time', function ($row) {
                return $row->payment->paid_on->format($this->settings->date_format);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'image', 'status'])
            ->toJson();
    }

    public function salesReportChart(Request $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report'), 403);

        $labels = [];
        $sales = [];
        $servicesArr = [];

        $services = BusinessService::select('id', 'slug', 'name')->orderBy('name')->get();

        $bookings = Booking::with('items')->whereMonth('date_time', $request->month)->whereYear('date_time', $request->year)->where('payment_status', 'completed')->get();

        foreach ($services as $service) {
            $servicesArr = Arr::add($servicesArr, $service->id, ['name' => $service->name, 'sales' => 0]);
            $labels[] = $service->name;
        }

        foreach ($bookings as $booking) {
            foreach ($booking->items as $item) {
                $servicesArr[$item->business_service_id]['sales'] += $item->quantity;
            }
        }

        foreach ($servicesArr as $service) {
            $sales[] = $service['sales'];
        }

        return Reply::dataOnly(['labels' => $labels, 'data' => $sales, 'status' => 'success']);
    }

    public function salesTable(Request $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report'), 403);

        $services = BusinessService::with('bookingItems', 'bookingItems.booking')
        ->whereHas('bookingItems.booking', function ($q) use ($request) {
            $q->whereMonth('date_time', $request->month)
            ->whereYear('date_time', $request->year)
            ->where('payment_status', 'completed');
        })->orderBy('name')
        ->get();

        // make booking items collection
        $items = [];
        foreach ($services as $service) {
            $bookingItems = $service->bookingItems()->whereHas('booking', function ($q) use ($request) {
                $q->whereMonth('date_time', $request->month)
                ->whereYear('date_time', $request->year)
                ->where('payment_status', 'completed');
            })->get();

            foreach ($bookingItems as $bookingItem) {
                $items[] = $bookingItem;
            }
        }

        return \datatables()->of(collect($items))
            ->editColumn('service_name', function ($row) {
                return ucwords($row->businessService->name);
            })
            ->editColumn('customer_name', function ($row) {
                return $row->booking->user->name;
            })
            ->editColumn('sales', function ($row) {
                return $row->quantity;
            })
            ->editColumn('amount', function ($row) {
                $taxAmount = $row->booking->tax_percent ? ($row->quantity * $row->unit_price * $row->booking->tax_percent / 100) : 0;
                $discountAmount = ($row->quantity * $row->unit_price * $row->booking->discount_percent / 100);

                $finalAmount = ($row->quantity * $row->unit_price) + $taxAmount - $discountAmount;
                return number_format((float) $finalAmount, 2, '.', '');
            })
            ->editColumn('paid_on', function ($row) {
                return $row->booking->payment->paid_on->format($this->settings->date_format);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'image', 'status'])
            ->toJson();
    }
}
