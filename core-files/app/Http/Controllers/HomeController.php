<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CompanyAdmin;
use App\Model\Company;
use App\Model\PurchaseOrder;
use App\Model\PurchasePayment;
use App\Model\PurchaseSalesDetail;
use App\Model\SalesChalan;
use App\Model\SalesOrder;
use App\Model\SalesPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Route;
use Khill\Lavacharts\Lavacharts;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->super_admin)
            $companies = Company::all();

        else{
            $userId = Auth::user()->id;
            $companies = Company::whereHas('users',function($query) use($userId){
                $query->where('user_id',$userId);
            })->get();

        }




        return view('admin.company.index')->with([
            'companies' => $companies
        ]);
    }

    public function companyDashboard(Request $request){

        $userId = Auth::user()->id;
        $parameters = Route::current()->parameters();
        if(isset($parameters['company_id'])){
            $company_id = $parameters['company_id'];
        }

        $companies = Company::all();

        $today = Carbon::now()->format('d');
        $yesterday = Carbon::now()->subday()->format('Y-m-d');
        $last_month = Carbon::now()->format('m');
        $last_year = Carbon::now()->format('Y');
//SELECT EXTRACT(MONTH FROM purchase_date) AS reference_month , SUM(amount) AS monthly_amount, SUM(paid_amount) AS monthly_paid, SUM(due_amount) AS monthly_due, AVG(amount) AS monthly_avg, count(amount) AS number_of_payments FROM purchase_orders GROUP BY EXTRACT(MONTH FROM purchase_date) ORDER BY EXTRACT(MONTH FROM purchase_date)
        //Purchase Overview query start from here
         $month_parches_overview = PurchaseOrder::where('company_id', $company_id)->selectRaw('EXTRACT(MONTH FROM purchase_date) AS reference_month , SUM(amount) AS monthly_amount, SUM(paid_amount) AS monthly_paid, SUM(due_amount) AS monthly_due, AVG(amount) AS monthly_avg, count(amount) AS number_of_payments')
             ->whereYear('purchase_date', $last_year)
             ->groupBy('reference_month')
             ->orderBy('id', 'desc')
             ->get();
         $current_month_purchase_overview = PurchaseOrder::where('company_id', $company_id)->selectRaw('SUM(amount) as current_month')
            ->whereMonth('purchase_date', $last_month)
            ->get();
         $today_purchase_overview = PurchaseOrder::where('company_id', $company_id)->selectRaw('SUM(amount) as current_day')
            ->whereMonth('purchase_date', $today)
            ->get();
         $yestarday_purchase_overview = PurchaseOrder::where('company_id', $company_id)->selectRaw('SUM(amount) as yesterday_overview')
            ->whereMonth('purchase_date', $yesterday)
            ->get();
         $purches_overviews = PurchaseOrder::where('company_id', $company_id)
             ->orderBy('id', 'desc')
             ->get();

        //Purchase Payment query start from here
         $current_month_parches_amounts = PurchasePayment::where('company_id', $company_id)->selectRaw('SUM(amount) as current_month')
            ->whereMonth('payment_date', $last_month)
            ->get();

         $today_parches_amounts = PurchasePayment::where('company_id', $company_id)->selectRaw('SUM(amount) as current_day')
            ->whereMonth('payment_date', $today)
            ->get();
         $yestarday_purchase_amounts = PurchasePayment::where('company_id', $company_id)->selectRaw('SUM(amount) as current_day')
             ->whereMonth('payment_date', $yesterday)
             ->get();
        //SELECT EXTRACT(MONTH FROM payment_date) AS reference_month , SUM(amount) AS monthly_payments, AVG(amount) AS monthly_avg, count(amount) AS number_of_payments FROM purchase_payments GROUP BY EXTRACT(MONTH FROM payment_date) ORDER BY EXTRACT(MONTH FROM payment_date)

        $monthly_parches_amount_query = PurchasePayment::where('company_id', $company_id)->selectRaw('EXTRACT(MONTH FROM purchase_payments.payment_date) AS reference_month , SUM(purchase_payments.amount) AS monthly_payments, AVG(purchase_payments.amount) AS monthly_avg, count(purchase_payments.amount) AS number_of_payments')
            ->whereYear('payment_date', $last_year )
            ->groupBy('reference_month')
            ->get();

         $recent_purchases = PurchasePayment::where('company_id', $company_id)
                                                ->orderBy('id', 'desc')
                                                ->get();
         //sales overview
        $monthly_sales_overviews = SalesOrder::where('company_id', $company_id)->selectRaw('EXTRACT(MONTH FROM sold_out_date) AS month , SUM(total_amount) AS monthly_total, SUM(paid_amount) AS monthly_paid, SUM(due_amount) AS monthly_due, count(sold_out_date) AS Order_total_number')
            ->whereYear('sold_out_date', $last_year)
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();
        $current_month_sales_overview = SalesOrder::where('company_id', $company_id)->selectRaw('SUM(total_amount) AS total, SUM(paid_amount) AS paid, SUM(due_amount) AS due, count(sold_out_date)')
            ->whereMonth('sold_out_date', $last_month)
            ->get();
        $today_sales_overview = SalesOrder::where('company_id', $company_id)->selectRaw('SUM(total_amount) AS total, SUM(paid_amount) AS paid, SUM(due_amount) AS due, count(sold_out_date)')
            ->whereMonth('sold_out_date', $today)
            ->get();
        $yestarday_sales_overview = SalesOrder::where('company_id', $company_id)->selectRaw('SUM(total_amount) AS total, SUM(paid_amount) AS paid, SUM(due_amount) AS due, count(sold_out_date)')
            ->whereMonth('sold_out_date', $yesterday)
            ->get();
        $sales_overviews = SalesOrder::where('company_id', $company_id)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        //sales payments
         $monthly_sales_payments = SalesPayment::where('company_id', $company_id)->selectRaw(' EXTRACT(MONTH FROM `payment_date`) AS month , SUM(`amount`) AS monthly_total, count(`payment_date`) AS Order_total_number')
             ->whereYear('payment_date', $last_year)
             ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();
          $current_month_sales_payment = SalesPayment::where('company_id', $company_id)->selectRaw('SUM(amount) AS total, count(payment_date)')
            ->whereMonth('payment_date', $last_month)
            ->get();
        $today_sales_payment = SalesPayment::where('company_id', $company_id)->selectRaw('SUM(amount) AS total, count(payment_date)')
            ->whereMonth('payment_date', $today)
            ->get();
        $yestarday_sales_payment = SalesPayment::where('company_id', $company_id)->selectRaw('SUM(amount) AS total, count(payment_date)')
            ->whereMonth('payment_date', $yesterday)
            ->get();
        $sales_payments = SalesPayment::where('company_id', $company_id)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        foreach($monthly_sales_payments as $k=>$value){
            $dataPoints1[] = array("label"=> $value->month, "y"=> $value->monthly_total);
        }

        foreach($month_parches_overview as $k=>$value){
            $dataPoints2[] = array("label"=> $value->reference_month, "y"=> $value->monthly_amount);
        }


        for ($i = 1; $i<= 12 ; $i++) {
            $purchased[$i] = 0;
        }

        foreach ($monthly_sales_payments as $value){
            if(array_key_exists($value->month, $purchased)){
                $purchased[$value->month] = $value->monthly_total;
            }
        }


        for ($i = 1; $i<= 12 ; $i++) {
            $sold[$i] = 0;
        }

        foreach ($month_parches_overview as $value){
            if(array_key_exists($value->reference_month, $sold)){
                $sold[$value->reference_month] = $value->monthly_amount;
            }
        }
        //return $purchased;




        $dataPoints1 = array(
            array("label"=> "Jan", "y"=> $purchased[1]),
            array("label"=> "Feb", "y"=> $purchased[2]),
            array("label"=> "March", "y"=> $purchased[3]),
            array("label"=> "April", "y"=> $purchased[4]),
            array("label"=> "May", "y"=> $purchased[5]),
            array("label"=> "Jun", "y"=> $purchased[6]),
            array("label"=> "July", "y"=> $purchased[7]),
            array("label"=> "Aug", "y"=> $purchased[8]),
            array("label"=> "Sep", "y"=> $purchased[9]),
            array("label"=> "Oct", "y"=> $purchased[10]),
            array("label"=> "Nov", "y"=> $purchased[11]),
            array("label"=> "Dec", "y"=> $purchased[12])
        );

        $dataPoints2 = array(
            array("label"=> "Jan", "y"=> $sold[1]),
            array("label"=> "Feb", "y"=> $sold[2]),
            array("label"=> "March", "y"=> $sold[3]),
            array("label"=> "April", "y"=> $sold[4]),
            array("label"=> "May", "y"=> $sold[5]),
            array("label"=> "Jun", "y"=> $sold[6]),
            array("label"=> "July", "y"=> $sold[7]),
            array("label"=> "Aug", "y"=> $sold[8]),
            array("label"=> "Sep", "y"=> $sold[9]),
            array("label"=> "Oct", "y"=> $sold[10]),
            array("label"=> "Nov", "y"=> $sold[11]),
            array("label"=> "Dec", "y"=> $sold[12])
        );






//        dd($dataPoints2);
        return view('admin.dashboard.company')->with([
            'companies' => $companies,
            'current_month_parches_amounts' => $current_month_parches_amounts,
            'today_parches_amounts' => $today_parches_amounts,
            'today' => $today,
            'yesterday' => $yesterday,
            'last_month' => $last_month,
            'last_year' => $last_year,
            'monthly_parches_amount_query' => $monthly_parches_amount_query,
            'recent_purchases' => $recent_purchases,
            'yestarday_purchase_amounts' => $yestarday_purchase_amounts,
            'month_parches_overview' => $month_parches_overview,
            'current_month_purchase_overview' => $current_month_purchase_overview,
            'today_purchase_overview' => $today_purchase_overview,
            'yestarday_purchase_overview' => $yestarday_purchase_overview,
            'purches_overviews' => $purches_overviews,
            'monthly_sales_overviews' => $monthly_sales_overviews,
            'current_month_sales_overview' => $current_month_sales_overview,
            'today_sales_overview' => $today_sales_overview,
            'yestarday_sales_overview' => $yestarday_sales_overview,
            'sales_overviews' => $sales_overviews,
            'monthly_sales_payments' => $monthly_sales_payments,
            'current_month_sales_payment' => $current_month_sales_payment,
            'today_sales_payment' => $today_sales_payment,
            'yestarday_sales_payment' => $yestarday_sales_payment,
            'sales_payments' => $sales_payments,
            'dataPoints1' =>  $dataPoints1,
            'dataPoints2' =>  $dataPoints2
        ]);
    }


    public function salesPurchasesChart($monthly_sales_payments,$month_parches_overview){
        foreach($monthly_sales_payments as $k=>$value){
            $dataPoints1[] = array("label"=> $value->month, "y"=> $value->monthly_total);
        }

        foreach($month_parches_overview as $k=>$value){
            $dataPoints2[] = array("label"=> $value->reference_month, "y"=> $value->monthly_amount);
        }

    }


}
