<?php

namespace App\Http\Controllers;

use App\Model\PaymentType;
use App\Model\PurchaseOrder;
use App\Model\PurchasePayment;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    public function index($company_id){
        $purchase_payments = PurchasePayment::where('company_id','=',$company_id)->with('purchaseOrder')->with('paymentType')->with('fields')->orderBy('purchase_order_id', 'desc')->get();
        return view('admin.purchase-payment.index')->with([
            'purchase_payments' => $purchase_payments
        ]);
    }

    public function create($company_id){
        $payment_types = PaymentType::with(['fields'])->where('company_id','=',$company_id)->get();
        $purchase_orders = PurchaseOrder::with(['vendor'])->where([
            ['company_id','=',$company_id],
            ['due_amount','>',0]
        ])->orderBy('id', 'asc')->get();
        return view('admin.purchase-payment.create')->with([
            'payment_types'     => $payment_types,
            'purchase_orders'   => $purchase_orders
        ]);
    }

    public function store(Request $request,$company_id){
        $purchase_payment = PurchasePayment::create($request->all());
        $field_data = [];
        $fields = $request->fields ? $request->fields : [];

        foreach ($fields as $k => $value){
            if(!empty($value)){
                $field_data[$k] = [
                    'field_value'   => $value,
                    'payment_type_field_id' => $k,
                    'purchase_payment_id'  => $purchase_payment->id,
                    'company_id'    => $company_id
                ];
            }
        }
        $purchase_payment->fields()->sync($field_data);
        return redirect()->route('purchase-payments',['company_id' => $request->route('company_id')]);
    }

}
