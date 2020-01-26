<?php

namespace App\Http\Controllers;

use App\Model\PaymentType;
use App\Model\SalesOrder;
use App\Model\SalesPayment;
use Illuminate\Http\Request;

class SalesPaymentController extends Controller
{
    public function index($company_id){
        $sales_payments = SalesPayment::with('paymentType')->with(['fields'])->where('company_id','=',$company_id)->orderBy('sales_order_id', 'desc')->get();
        return view('admin.sales-payment.index')->with([
            'sales_payments' => $sales_payments
        ]);
    }

    public function create($company_id){
        $payment_types = PaymentType::with(['fields'])->where('company_id','=',$company_id)->get();
        $sales_orders = SalesOrder::where([
            ['company_id','=',$company_id],
            ['due_amount','>',0]
        ])->with('customer')->orderBy('so_no_manual', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.sales-payment.create')->with([
            'payment_types'     => $payment_types,
            'sales_orders'   => $sales_orders
        ]);
    }

    public function store(Request $request,$company_id){
        $sales_payment = new SalesPayment();
        $sales_payment->sales_order_id = $request->sales_order_id;
        $sales_payment->so_no_manual = $request->so_no_manual_id;
        $sales_payment->payment_type_id = $request->payment_type_id;
        $sales_payment->payment_date = $request->payment_date;
        $sales_payment->amount = $request->amount;
        $sales_payment->save();
        $field_data = [];
        $fields = $request->fields ? $request->fields : [];

        foreach ($fields as $k => $value){
            if(!empty($value)){
                $field_data[$k] = [
                    'field_value'   => $value,
                    'payment_type_field_id' => $k,
                    'sales_payment_id'  => $sales_payment->id,
                    'company_id'    => $company_id
                ];
            }
        }

        $sales_payment->fields()->sync($field_data);
        return redirect()->route('sales-payments',['company_id' => $request->route('company_id')]);
    }

    public function show($company_id, $id){
         $sales_payment = SalesPayment::where('company_id', $company_id)
            ->where('id', $id)
            ->first();
         $sales_order = SalesOrder::select(['id', 'type'])->where('id', $sales_payment->sales_order_id)
            ->first();

         if ($sales_order->type == 0){
             return redirect()->route('show-sales-order', ['company_id' => $company_id,'id' => $sales_order->id]);
         }elseif ($sales_order->type == 1){
             return redirect()->route('show-purchase-sales-order', ['company_id' =>$company_id,'id' => $sales_order->id]);

         }
    }
}
