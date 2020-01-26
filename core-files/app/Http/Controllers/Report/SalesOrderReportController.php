<?php

namespace App\Http\Controllers\Report;

use App\Model\Company;
use App\Model\Customer;
use App\Model\Good;
use App\Model\SalesOrder;
use App\Model\SalesOrderDetail;
use PDF;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesOrderReportController extends Controller
{
    public function getSalesOrdersReport($company_id){
        $company = Company::findOrFail($company_id);
        return view('admin.report.report-sales-order')->with('company_name', $company->name);
    }
    public function getJsonGoodsForSalesOrderReport($company_id){
        $goods = Good::where('company_id' , $company_id)->with('unit')->orderBy('name', 'asc')->get();
        return response()->json($goods, 200);
    }

    public function getJsonCustomersForSalesOrderReport($company_id){

        $customers_query = Customer::where('company_id', '=' ,$company_id)->orderBy('name','asc');
        $customers =$customers_query->get();
        return response()->json($customers, 200);
    }

    public function postJsonSalesOrderReport($company_id, Request $request){

        $sales_order_report_query = SalesOrderDetail::select('good_id', DB::raw('SUM(sub_total) as sold_total'), DB::raw('SUM(quantity) as quantities'))
            ->with(['good' => function ($query){
                $query->withTrashed()->with('unit');
            }])
            ->where('company_id', $company_id)->groupBy('good_id');

        if ($request->good_id){
            $sales_order_report_query->where('good_id', $request->good_id);
        }

        $wheres[] = ['company_id', $company_id];
        $wheres[] = ['type', 0];
        if ($request->customer_id){
            $wheres[] = ['customer_id', $request->customer_id];
        }
        if ($request->customer_name){
            $wheres[] = ['name', 'like', "%".$request->customer_name."%"];
        }
        if ($request->date_from && $request->date_from != "Invalid date"){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['sold_out_date', '>=', $date_from];
        }
        if ($request->date_to && $request->date_to != "Invalid date"){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['sold_out_date', '<=', $date_to];
        }
        $sales_order_report_query->whereHas('salesOrder', function ($query) use($wheres){
            $query->where($wheres);
        });

        if ($request->item_per_page){
            $sales_order_report = $sales_order_report_query->paginate($request->item_per_page);
        }else{
            $sales_order_report = $sales_order_report_query->paginate(10);
        }

        return response()->json([
            'sales_order_report'=>$sales_order_report
        ],200);
    }

    public function getDownloadSalesOrderReport($company_id, Request $request){
        $sales_order_report_query = SalesOrderDetail::select('good_id', DB::raw('SUM(sub_total) as sold_total'), DB::raw('SUM(quantity) as quantities'))
            ->with(['good' => function ($query){
                $query->withTrashed()->with('unit');
            }])
            ->where('company_id', $company_id)->groupBy('good_id');

        if ($request->good_id){
            $sales_order_report_query->where('good_id', $request->good_id);
        }

        $wheres[] = ['company_id', $company_id];
        $wheres[] = ['type', 0];
        if ($request->customer_id){
            $wheres[] = ['customer_id', $request->customer_id];
        }
        if ($request->customer_name){
            $wheres[] = ['name', 'like', "%".$request->customer_name."%"];
        }
        if ($request->date_from && $request->date_from != "Invalid date"){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['sold_out_date', '>=', $date_from];
        }
        if ($request->date_to && $request->date_to != "Invalid date"){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['sold_out_date', '<=', $date_to];
        }
        $sales_order_report_query->whereHas('salesOrder', function ($query) use($wheres){
            $query->where($wheres);
        });

        $sales_order_report = $sales_order_report_query->get();

//        --------------------------------
        if($request->customer_id){
           $customer = Customer::find($request->customer_id) ? Customer::find($request->customer_id)->name : "Error" ;
        }elseif ($request->customer_name){
            $customer = $request->customer_name;
        }else{
            $customer = null;
        }

        if ($request->good_id){
            $good = Good::find($request->good_id) ? Good::find($request->good_id)->detail_name : "Error";
        }else{
            $good = null;
        }

        if($request->date_from && $request->date_from != "Invalid date"){
            $date_from = Carbon::parse($request->date_from)->toFormattedDateString();
        }else{
            $date_from = null;
        }

        if($request->date_to && $request->date_to != "Invalid date"){
            $date_to = Carbon::parse($request->date_to)->toFormattedDateString();
        }else{
            $date_to = null;
        }

        $report_generated_date = Carbon::now()->toDayDateTimeString();
        if (count($sales_order_report)){
            $total = 0;
            foreach ($sales_order_report as $item){
                $total += $item->sold_total;
            }
        }

        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.report.report-sales-order', [
            'company'               => $company,
            'customer'              => $customer,
            'good'                  => $good,
            'date_from'             => $date_from,
            'date_to'               => $date_to,
            'report_generated_date' => $report_generated_date,
            'sales_order_report'    => $sales_order_report,
            'total'                => $total,
        ]);
        return $pdf->stream();


    }
}
