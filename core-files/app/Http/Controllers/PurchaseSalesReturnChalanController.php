<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\PurchaseSalesChalanDetail;
use App\Model\PurchaseSalesDetail;
use App\Model\SalesChalan;
use App\Model\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class PurchaseSalesReturnChalanController extends Controller
{
    public function index($company_id){
        $chalans = SalesChalan::where([
            ['company_id','=', $company_id],
            ['type','=',4]
        ])->orderBy('id','desc')->get();
        return view('admin.purchase-sales-return-chalan.index')->with([
            'chalans'   => $chalans
        ]);
    }

    public function getChalan($company_id,$id){
        $chalan = SalesChalan::where([
            ['company_id','=',$company_id],
            ['id','=',$id]
        ])->first();
        return view('admin.purchase-sales-return-chalan.details')->with([
            'chalan'    => $chalan
        ]);
    }

    public function create($company_id){

        $date = Carbon::today();
        $pd = count(SalesChalan::all()) + 1;
        $ch_no = 'CH-'.$date->year.'-' . $date->month.'-'. $date->day. '-' .str_pad($pd,4,'0',STR_PAD_LEFT);
        $sales_orders = SalesOrder::where('company_id','=',$company_id)
            ->where('type','=',1)->orderBy('id','desc')->get();
        return view('admin.purchase-sales-return-chalan.create')->with([
            'sales_orders'   => $sales_orders,
            'ch_auto' => $ch_no
        ]);
    }


    public function getSalesOrderItems($company_id,$id){
        $sale_order_items = PurchaseSalesDetail::with(['inventoryItem.','unit'])->where([
            ['sales_order_id','=',$id],
            ['company_id','=',$company_id]
        ])->get();
        return response()->json($sale_order_items,200);
    }

    public function store(Request $request,$company_id){


        $sales_order = SalesOrder::where([
            ['company_id','=',$company_id],
            ['id','=',$request->input('sales_order_id')],
            ['type','=',4],
        ])->firstOrFail();

        $chalan = SalesChalan::create([
            'sales_order_id' => $sales_order->id,
            'chalan_date'   => $request->input('chalan_date'),
            'chalan_no'     => $request->input('chalan_no'),
            'chalan_no_manual' => $request->input('chalan_no_manual'),
            'type'  => $request->input('type') ? $request->input('type') : 0
        ]);

        $created = false;

        foreach ($request->input('sales_od') as $k => $v){
            $od = PurchaseSalesDetail::findOrFail($v['sales_od_id']);
            if(isset($v['quantity']) && $v['quantity'] > 0){
                PurchaseSalesChalanDetail::create([
                    'chalan_id' => $chalan->id,
                    'purchase_sales_detail_id' => $od->id,
                    'inventory_item_id' => $od->inventory_item_id,
                    'received_qty'  => $v['quantity'],
                    'product_amount' => $od->unit_price * $v['quantity'],
                ]);

                $created = true;
            }

        }
        if(!$created)
        {
            $chalan->delete();
            return redirect()->back()->with([
                'message' => [
                    'status'    => 'alert-danger',
                    'text'      => 'Please enter the valid quantity.'
                ]
            ]);
        }


        return redirect()->route('purchase-sales-return-chalans',['company_id' => $request->route('company_id')])->with([
            'message' => [
                'status'    => 'alert-success',
                'text'      => 'Successfully created chalan.'
            ]
        ]);

    }

    public function download($company_id,$id){
        $chalan = SalesChalan::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
            ['type','=',3],
        ])->firstOrFail();
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.chalan', [
            'sales_order'    => $chalan,
            'company'       => $company
        ]);
        return $pdf->stream();
    }
}
