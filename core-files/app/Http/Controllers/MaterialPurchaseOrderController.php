<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\InventoryItem;
use App\Model\ProductTransition;
use App\Model\PurchaseOrder;
use App\Model\PurchaseOrderDetail;
use App\Model\RawMaterial;
use App\Model\Vendor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class MaterialPurchaseOrderController extends Controller
{
    public function getJsonVendors($company_id){
        $vendors = Vendor::where('company_id','=',$company_id)->orderBy('name', 'asc')->get();
        return response()->json($vendors, 200);
    }

    public function getJsonMaterials($company_id){
        $materials = RawMaterial::select('id', 'name', 'unit_id')->with(['unit' => function($query){
            $query->select('id', 'name');
        }])->where('company_id','=',$company_id)->orderBy('name', 'asc')->get();
        return response()->json($materials, 200);
    }

    public function postJsonMaterialItem($company_id, Request $request){
        //return $request->all();

        try{
            if(!$request->purchase_order_id){
                $purchase_order = new PurchaseOrder();
                $purchase_order->vendor_id = $request->vendor_id;
                $purchase_order->challan_no_mannual = $request->challan_no_mannual;
                $purchase_order->additional_challan_no_mannual = $request->additional_challan_no_mannual;
                $purchase_order->purchase_date = Carbon::parse($request->purchase_date)->format('Y-m-d');
                $purchase_order->company_id = $company_id;
                $purchase_order->created_by = $request->_user_info['id'];
                $purchase_order->save();

            }else{
                $purchase_order_id = $request->purchase_order_id;

                $purchase_order = PurchaseOrder::where([
                    ['company_id' , $company_id],
                    ['id', $purchase_order_id],
                ])->first();

                if ($request->vendor_id){
                    $purchase_order->vendor_id = $request->vendor_id;
                }

                if ($request->challan_no_mannual){
                    $purchase_order->challan_no_mannual = $request->challan_no_mannual;
                }

                if ($request->additional_challan_no_mannual){
                    $purchase_order->additional_challan_no_mannual = $request->additional_challan_no_mannual;
                }

                if ($request->purchase_date){
                    $purchase_order->purchase_date = Carbon::parse($request->purchase_date)->format('Y-m-d');
                }
                $purchase_order->save();
            }
            $raw_material = RawMaterial::findOrFail($request->material_id);

            $inventory_item = InventoryItem::firstOrCreate([
                'raw_material_id'   => $raw_material->id,
                'size'              => $request->size,
                'thickness'         => $request->thickness,
                'type'              => $request->material_type,
                'unit_id'           => $raw_material->unit_id,
                'company_id'        => $company_id
            ]);

            $amount =((float)($request->quantity ?? 0) * (float)($request->price_per_pnit ?? 0));

            $material_item = new ProductTransition();
            $material_item->order_id = $purchase_order->id;
            $material_item->raw_material_id = $raw_material->id;
            $material_item->inventory_item_id = $inventory_item->id;
            $material_item->unit_id = $raw_material->unit_id;
            $material_item->quantity = $request->quantity;
            $material_item->price_per_unit = $request->price_per_pnit;
            $material_item->amount = $amount;
            $material_item->company_id = $company_id;
            $material_item->material_type = $request->material_type;
            $material_item->transition_type = 'POD';
            //$material_item->challan_no_mannual = $purchase_order->challan_no_mannual;
            $material_item->save();

            $material_item->load(['rawMaterial', 'unit', 'inventoryItem']);

            $message = [
                'status' => "success",
                'message' => "Material item add successfully!",
            ];

            return response()->json([
                'purchase_order' => $purchase_order,
                'material_item' => $material_item,
                'message' => $message,
            ], 200);

        }catch (Exception $e){
            $message = [
                'status' => "danger",
                'message' => "Something wrong! Try again." . $e->getMessage(),
            ];
            return response()->json([
                'message' => $message,
            ], 400);
        }
    }

    public function deleteJsonMaterialItem($company_id, $id){
        try{
            $material_item = ProductTransition::where([
                ['company_id' , $company_id],
                ['id', $id],
            ])->first();
            $material_item->delete();
            $message = [
                'status' => "success",
                'message' => "Material Item deleted successfully!",
            ];
            return response()->json($message, 200);
        }catch (Exception $e){
            $message = [
                'status' => "error",
                'message' => "Something wrong! Try again.",
            ];
            return response()->json($message, 400);
        }
    }

    public function postJsonSavePurchaseOrder($company_id, Request $request){
        try{

            if ($request->purchase_order_id){
                $purchase_order_id = $request->purchase_order_id;
                $purchase_order = PurchaseOrder::where([
                    ['company_id' , $company_id],
                    ['id', $purchase_order_id],
                ])->first();

                if ($request->vendor_id){
                    $purchase_order->vendor_id = $request->vendor_id;
                }
                if ($request->challan_no_mannual){
                    $purchase_order->challan_no_mannual = $request->challan_no_mannual;
                }

                if ($request->additional_challan_no_mannual){
                    $purchase_order->additional_challan_no_mannual = $request->additional_challan_no_mannual;
                }

                if ($request->purchase_date){
                    $purchase_order->purchase_date = Carbon::parse($request->purchase_date)->format('Y-m-d');
                }


                $amount = ProductTransition::where([
                    ['company_id' , $company_id],
                    ['order_id', $purchase_order->id],
                ])->sum('amount');
//
//                $amount = 0;
//                foreach ($material_items as $k => $material){
//
//                    $amount = $amount + $material->amount;
//                }
                $purchase_order->amount = $amount;
                $purchase_order->due_amount = $amount;
                $purchase_order->status = 1;
                $purchase_order->saved_by = $request->_user_info['id'];
                $purchase_order->save();

                $redirect_route = route('materialPurchaseOrders.index', ['company_id' => $company_id]);
                $message = [
                    'status' => "success",
                    'message' => "Success! Purchase Order has saved.",
                ];

                return response()->json([
                    'message' => $message,
                    'redirect_route' => $redirect_route
                ],200);

            }else{
                $message = [
                    'status' => "error",
                    'message' => "Something wrong! Try again. (Purchase order problem)",
                ];
                return response()->json($message, 400);
            }
        }catch (Exception $e){
            $message = [
                'status' => "error",
                'message' => "Something wrong! Try again.".$e,
            ];
            return response()->json($message, 400);
        }
    }

    public function drafts($company_id){
        $drafts = PurchaseOrder::where([
            ['company_id', $company_id],
            ['status', 0],
            ['created_by', Auth::id()],
        ])->with('vendor')->whereHas('materials')->get();
        return view('admin.purchase-order-material.drafts')->with('drafts', $drafts);
    }

    public function draft($company_id, $id){
        $draft = PurchaseOrder::where([
            ['id', $id],
            ['company_id', $company_id],
            ['status', 0],
            ['created_by', Auth::id()],
        ])->with('vendor')->with(['materials'=> function($query){
            $query->with(['rawMaterial', 'unit', 'inventoryItem']);
        }])->first();
        return view('admin.purchase-order-material.draft')->with('draft', $draft);
    }

    public function deleteDraft($company_id, $id){
        $draft = PurchaseOrder::where([
            ['id', $id],
            ['company_id', $company_id],
            ['status', 0],
            ['created_by', Auth::id()],
        ])->first();

        if ($draft){
            $draft->materials()->delete();
            $draft->delete();
            return redirect()->back()->withSuccess('Draft Order has deleted successfully!');
        }else{
            return redirect()->back()->withWarning('Something is wrong! Please try again later.');
        }
    }

    public function getJsonMaterialPurchaseOrders($company_id, Request $request){
        $material_purchase_orders_query = PurchaseOrder::orderBy('purchase_date', 'desc')->whereHas('materials')->with('vendor');
        $wheres[] = ['company_id', $company_id];
        $wheres[] = ['status', 1];
        if ($request->id){
            $wheres[] = ['id', $request->id];
        }
        if($request->challan_no_mannual){
            $wheres[] = ['challan_no_mannual', $request->challan_no_mannual];
        }
        if($request->date_from && $request->date_from != "Invalid date"){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['purchase_date','>=', $date_from];
        }
        if($request->date_to && $request->date_to != "Invalid date"){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['purchase_date','<=', $date_to];
        }
        if($request->vendor_name){
            $vendor_name = $request->vendor_name;
            $material_purchase_orders_query->whereHas('vendor', function ($query) use($vendor_name){
                $query->where('name','like','%'.$vendor_name.'%');
            });
        }

        $material_purchase_orders_query->where($wheres);

        if ($request->item_per_page){
            $material_purchase_orders = $material_purchase_orders_query->paginate($request->item_per_page);
        }else{
            $material_purchase_orders = $material_purchase_orders_query->paginate(10);
        }

        return response()->json([
            'material_purchase_orders' => $material_purchase_orders,
        ], 200);
    }

    public function show($company_id, $id){
        $material_purchase_order = PurchaseOrder::where([
            'company_id'    => $company_id,
            'id'            => $id,
            'status'        => 1,
        ])->firstOrFail();
        $material_purchase_order->load(['rawMaterials', 'otherMaterials']);


        return view('admin.purchase-order-material.show')->with([
            'material_purchase_order'    => $material_purchase_order
        ]);
    }

    public function edit($company_id, $id){
        $material_purchase_order = PurchaseOrder::where([
            ['id', $id],
            ['company_id', $company_id],
        ])->with('vendor')->with(['materials'=> function($query){
            $query->with(['rawMaterial','unit']);
        }])->first();
        $material_purchase_order->status = 0;
        $material_purchase_order->save();

        return view('admin.purchase-order-material.edit')->with('material_purchase_order', $material_purchase_order);
    }

    public function updateJsonPurchaseOrder($company_id, $id, Request $request){
        try{
            $purchase_order = PurchaseOrder::where([
                ['company_id' , $company_id],
                ['id', $id],
            ])->first()->load('materials.rawMaterial.unit');

            if($request->vendor_id){
                $purchase_order->vendor_id = $request->vendor_id;
            }
            if($request->challan_no_mannual){
                $purchase_order->challan_no_mannual = $request->challan_no_mannual;
            }
            if($request->additional_challan_no_mannual){
                $purchase_order->additional_challan_no_mannual = $request->additional_challan_no_mannual;
            }
            if($request->purchase_date){
                $purchase_order->purchase_date = Carbon::parse($request->purchase_date)->format('Y-m-d');
            }

            $material_items = PurchaseOrderDetail::where([
                ['company_id' , $company_id],
                ['purchase_order_id', $purchase_order->id],
            ])->get();

            $amount = 0;
            foreach ($material_items as $k => $material){
                $material_item = PurchaseOrderDetail::find($material->id);
                $material_item->challan_no_mannual = $purchase_order->challan_no_mannual;
                $material_item->save();

                $amount = $amount + $material_item->amount;
            }
            $purchase_order->amount = $amount;
            $purchase_order->due_amount = $amount - $purchase_order->paid_amount;
            $purchase_order->status = 1;
            $purchase_order->updated_by = $request->_user_info['id'];
            $purchase_order->save();
            $redirect_route = route('materialPurchaseOrders.index', ['company_id' => $company_id]);

            $message = [
                'status' => "success",
                'message' => "Success! Purchase Order has Updated.",
            ];

            return response()->json([
                'message' => $message,
                'redirect_route' => $redirect_route
            ],200);

        }catch (Exception $e){
            $message = [
                'status' => "error",
                'message' => "Something wrong! Try again.".$e,
            ];
            return response()->json($message, 400);
        }
    }

    public function deleteJsonPurchaseOrder($company_id, $id){
        try{
            $purchase_order = PurchaseOrder::where([
                ['company_id' , $company_id],
                ['status' , 1],
                ['id', $id],
            ])->first();
            $purchase_order->materials()->delete();
            $purchase_order->delete();
            $message = [
                'status' => "success",
                'message' => "Success! Purchase Order has deleted.",
            ];
            $redirect_route = route('materialPurchaseOrders.index', ['company_id' => $company_id]);
            return response()->json([
                'message' => $message,
                'redirect_route' => $redirect_route
            ],200);

        }catch (Exception $e){
            $message = [
                'status' => "error",
                'message' => "Something wrong! Try again.".$e,
            ];
            return response()->json($message, 400);
        }
    }

    public function getDownloads($company_id, Request $request){
        $company = Company::find($company_id);
        $material_purchase_orders_query = PurchaseOrder::orderBy('purchase_date', 'desc')->whereHas('materials')->with('vendor');
        $wheres[] = ['company_id', $company_id];
        $wheres[] = ['status', 1];
        if ($request->id){
            $wheres[] = ['id', $request->id];
        }
        if($request->challan_no_mannual){
            $wheres[] = ['challan_no_mannual', $request->challan_no_mannual];
        }
        if($request->date_from && $request->date_from != "Invalid date"){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['purchase_date','>=', $date_from];
        }
        if($request->date_to && $request->date_to != "Invalid date"){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['purchase_date','<=', $date_to];
        }
        if($request->vendor_name){
            $vendor_name = $request->vendor_name;
            $material_purchase_orders_query->whereHas('vendor', function ($query) use($vendor_name){
                $query->where('name','like','%'.$vendor_name.'%');
            });
        }

        $material_purchase_orders_query->where($wheres);

        if ($request->item_per_page){
            $material_purchase_orders = $material_purchase_orders_query->paginate($request->item_per_page);
        }else{
            $material_purchase_orders = $material_purchase_orders_query->paginate(10);
        }


        $pdf = PDF::loadView('pdf.material_purchase_order.index', [
            'material_purchase_orders'    => $material_purchase_orders,
            'company'       => $company
        ]);
        return $pdf->stream();
    }

    public function getDownloadMaterialPurchaseOrder($company_id, $id){
        $company = Company::findOrFail($company_id);
        $material_purchase_order = PurchaseOrder::where([
            'company_id'    => $company_id,
            'id'            => $id,
            'status'        => 1,
        ])->firstOrFail();
        $material_purchase_order->load(['rawMaterials', 'otherMaterials']);

        $pdf = PDF::loadView('pdf.material_purchase_order.show', [
            'company'           => $company,
            'material_purchase_order'    => $material_purchase_order,
        ]);
        return $pdf->stream();
    }
}


