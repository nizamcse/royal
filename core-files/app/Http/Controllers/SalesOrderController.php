<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Customer;
use App\Model\Good;
use App\Model\SalesOrder;
use App\Model\SalesOrderDetail;
use App\Model\SalesOrderOtherChargeDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SalesOrderController extends Controller
{
    public function index($company_id){
        return view('admin.sales-order.index');
    }

    public function getSalesOrders(Request $request,$company_id){
        $wheres[] = ['company_id','=',$company_id];
        $wheres[] = ['type','=',0];

        if($request->id){
            $wheres[] = ['id','=',$request->id];
        }
        if($request->so_no_manual){
            $wheres[] = ['so_no_manual','=',$request->so_no_manual];
        }
        if($request->date_from){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['sold_out_date','>=',$date_from];
        }
        if($request->date_to){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['sold_out_date','<=',$date_to];
        }
        if($request->name){

            $name  = $request->name;
            $wheres[] = ['name','like','%'.$name.'%'];
        }
        if($request->contact_no){
            $wheres[] = ['contact_no','=', $request->contact_no];
        }
        $sales_orders = SalesOrder::where($wheres)->orderBy('sold_out_date','DESC')->with('customer')->paginate(10);
        return response()->json($sales_orders,200);
    }

    public function downloadSalesOrders (Request $request,$company_id){
        $wheres[] = ['company_id','=',$company_id];
        $wheres[] = ['type','=',0];

        if($request->id){
            $wheres[] = ['id','=',$request->id];
        }
        if($request->date_from){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['sold_out_date','>=',$date_from];
        }
        if($request->date_to){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['sold_out_date','<=',$date_to];
        }
        if($request->name){
            $name  = $request->name;
            $wheres[] = ['name','like','%'.$name.'%'];
            $wheres[] = ['contact_no','like','%'.$name.'%'];
        }
        $sales_orders = SalesOrder::where($wheres)->orderBy('sold_out_date','DESC')->with('customer')->paginate(10);
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.sales-orders', [
            'sales_orders'    => $sales_orders,
            'company'       => $company
        ]);
        return $pdf->stream();
    }

    public function create(){
        return view('admin.sales-order.create');
    }

    public function show($company_id,$id){
        $sales_order = SalesOrder::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
            ['type','=',0]
        ])->firstOrFail();
        return view('admin.sales-order.show')->with([
            'sales_order'  => $sales_order
        ]);
    }

    public function store(Request $request,$company_id){

        try{
            DB::beginTransaction();

            $customer = Customer::find($request->customer_id);

            $sales_order = new SalesOrder();
            $sales_order->customer_id = $request->customer_id;
            $sales_order->name = $customer->name;
            $sales_order->contact_no = $customer->contact_no;
            $sales_order->address = $customer->address;
            $sales_order->so_no_manual = $request->so_no_manual;
            $sales_order->additional_so_no_manual = $request->additional_so_no_manual;
            $sales_order->sold_out_date = Carbon::parse($request->sold_out_date)->format('Y-m-d');
            $sales_order->other_charge = $request->other_charge;
            $sales_order->total_discount = $request->total_discount;
            $sales_order->created_by = $request->_user_info['id'];
            $sales_order->save();

            $other_charge_details = $request->other_charge_details;
            $goods = $request->goods;

            if ($other_charge_details && count($other_charge_details)){
                foreach($other_charge_details as $other_charge_detail){
                    $sales_order_other_charge_detail = new SalesOrderOtherChargeDetail();
                    $sales_order_other_charge_detail->sales_order_id = $sales_order->id;
                    $sales_order_other_charge_detail->charge_description = $other_charge_detail['charge_description'];
                    $sales_order_other_charge_detail->charge_amount = $other_charge_detail['charge_amount'];
                    $sales_order_other_charge_detail->save();
                }
            }

            $total_price = 0;
            $payable_amount = 0;

            if( $goods && count($goods)){

                foreach ($goods as $good){

                    $g = Good::findOrFail($good['id']);

                    $sub_total = $good['quantity'] * $g->price;
                    $discount_amount = $sub_total * $good['discount'] * 0.01;
                    $sold_sub_total = $sub_total - $discount_amount;

                    $sales_order_detail = new SalesOrderDetail();
                    $sales_order_detail->sales_order_id = $sales_order->id;
                    $sales_order_detail->good_id = $g->id;
                    $sales_order_detail->unit_id = $g->unit_id;
                    $sales_order_detail->unit_price = $g->price;
                    $sales_order_detail->sub_total = $sold_sub_total;
                    $sales_order_detail->base_price = $sub_total;
                    $sales_order_detail->quantity = $good['quantity'];
                    $sales_order_detail->discount = !empty($good['discount']) ? $good['discount'] : 0;
                    $sales_order_detail->remaining_quantity = $good['quantity'];
                    $sales_order_detail->save();

                    $total_price += $sub_total; // sum of actual price of all goods with quantities.
                    $payable_amount += $sold_sub_total;
                }
            }

            if ($request->other_charge){
                $payable_amount = $payable_amount + $request->other_charge;
            }
            if ($request->total_discount){
                $payable_amount = $payable_amount - $request->total_discount;
            }

            $sales_order->total_amount = $total_price; // sum of actual price of all goods with quantities.
            $sales_order->due_amount = $payable_amount;
            $sales_order->payable_amount = $payable_amount;
            $sales_order->save();
            DB::commit();

            return redirect()->route('sales-orders',['company_id' => $request->route('company_id')])->withMessage([
                'status'    => true,
                'text'      => 'Successfully created purchase.'
            ]);

        }catch (Exception $exception){
            DB::rollBack();
            return "Sorry, try again!";
        }
    }

    public function download($company_id,$id){
        $sales_order = SalesOrder::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
            ['type','=',0]
        ])->firstOrFail();
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.sales-order', [
            'sales_order'    => $sales_order,
            'company'       => $company
        ]);
        return $pdf->stream();
    }

    public function getJsonGoodsForSalesOrder($company_id){
        $goods = Good::where('company_id' , $company_id)->with('unit')->orderBy('name', 'asc')->get();
        return response()->json($goods, 200);
    }

    public function getJsonCustomersForSalesOrder($company_id){

        $customers_query = Customer::where('company_id', '=' ,$company_id)->orderBy('name','asc');
        $customers =$customers_query->get();
        return response()->json($customers, 200);
    }
}
