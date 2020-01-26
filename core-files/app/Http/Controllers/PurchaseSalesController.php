<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Customer;
use App\Model\InventoryItem;
use App\Model\ProductTransition;
use App\Model\PurchaseOrder;
use App\Model\PurchaseOrderDetail;
use App\Model\PurchaseSalesDetail;
use App\Model\SalesOrder;
use App\Model\SalesOrderOtherChargeDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PurchaseSalesController extends Controller
{
    public function index($company_id){
        $sales_orders = SalesOrder::where('company_id','=',$company_id)
            ->whereType(1)
            ->orderBy('sold_out_date','DESC')->with('customer')->get();
        return view('admin.purchase-sales-order.index')->with([
            'sales_orders'  => $sales_orders
        ]);
    }

    public function getPurchaseSalesOrders(Request $request,$company_id){
        $wheres[] = ['company_id','=',$company_id];
        $wheres[] = ['type','=',1];

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
    public function show_orders($company_id){
        $sales_orders = SalesOrder::where('company_id','=',$company_id)
            ->whereType(1)
            ->orderBy('sold_out_date','DESC')->with('customer')->get();
        return response()->json([
            'sales_orders'  => $sales_orders
        ], 200);
    }

    public function create($company_id){
        return view('admin.purchase-sales-order.create');
    }

    public function show($company_id,$id){
        $sales_order = SalesOrder::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
            ['type','=',1]
        ])->firstOrFail();
        return view('admin.purchase-sales-order.show')->with([
            'sales_order'  => $sales_order
        ]);
    }

    public function store(Request $request,$company_id){
        //return $request->all();

        try{
            DB::beginTransaction();

            $customer = Customer::find($request->customer_id);

            $sales_order = new SalesOrder();
            $sales_order->type = 1;
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


            if($goods && count($goods)){
                foreach ($goods as $good){
                    //dd($good);
                    //$g = InventoryItem::findOrFail($good['id']);
                    $g = ProductTransition::findOrFail($good['id']);
                    $sub_total = $good['quantity'] * $good['price'];
                    $discount_amount = $sub_total * $good['discount'] * 0.01;
                    $sold_sub_total = $sub_total - $discount_amount;

                    $purchase_sales_detail = new ProductTransition();
                    $purchase_sales_detail->order_id = $sales_order->id;
                    $purchase_sales_detail->parent_id = $g->id;
                    $purchase_sales_detail->inventory_item_id = $g->inventory_item_id;
                    $purchase_sales_detail->unit_id = $g->unit_id;
                    $purchase_sales_detail->price_per_unit = $good['price'];
                    $purchase_sales_detail->amount = $sold_sub_total;
                    $purchase_sales_detail->base_price = $sub_total;
                    $purchase_sales_detail->quantity = $good['quantity'] * -1;
                    $purchase_sales_detail->discount = !empty($good['discount']) ? $good['discount'] : 0;
                    $purchase_sales_detail->r_w_quantity = $good['quantity'];
                    $purchase_sales_detail->transition_type = 'PSD';
                    $purchase_sales_detail->raw_material_id = $g->raw_material_id;
                    $purchase_sales_detail->save();

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
            return redirect()->route('purchase-sales-orders',['company_id' => $request->route('company_id')])->withMessage([
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
            'company_id'    => $company_id,
            'id'            => $id
        ])->firstOrFail();
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.purchase-sales-order', [
            'sales_order'    => $sales_order,
            'company'       => $company
        ]);
        return $pdf->stream();
    }

    public function getJsonGoodsForPurchaseSale($company_id){
        $products = InventoryItem::with(['rawMaterial','unit'])->where([
            ['company_id','=', $company_id],
            ['quantity','>', 0]
        ])->get();

        return response()->json($products, 200);
    }

    public function getJsonRemGoodsForPurchaseSale($company_id){
//        $products = InventoryItem::with(['rawMaterial','unit'])->where([
//            ['company_id','=', $company_id],
//            ['quantity','>', 0]
//        ])->get();

        $product_transitions = ProductTransition::where([
            ['r_w_quantity','>',0],
            ['transition_type','=','POD'],
            ['company_id','=', $company_id],
        ])->get();

        $products = [];

        foreach ($product_transitions as $product_transition){
            $products[] = [
                'id'    => $product_transition->id,
                'remaining_quantity'    => $product_transition->r_w_quantity,
                'price'    => $product_transition->price_per_unit,
                'po_id' => $product_transition->order_id,
                'unit_id'   => $product_transition->unit_id,
                'unit_name' => $product_transition->unit_name,
                'name'  => $product_transition->name,
                'material_type' => $product_transition->material_type
            ];
        }

        return response()->json($products, 200);
    }

    public function getJsonCustomersForPurchaseSale($company_id){

        $customers_query = Customer::where('company_id', '=' ,$company_id)->orderBy('name','asc');
        $customers =$customers_query->get();
        return response()->json($customers, 200);
    }
    public  function  delete($company_id, $id){
        return "Delete";
        return redirect()->back();
    }
}
