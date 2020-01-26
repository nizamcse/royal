<?php

namespace App\Http\Controllers;

use App\Category;
use App\Model\Company;
use App\Model\Grade;
use App\Model\PurchaseOrder;
use App\Model\PurchaseOrderDetailLog;
use App\Model\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use PDF;
use Illuminate\Support\Facades\Auth;

class LogPurchaseOrderController extends Controller
{
    public function getJsonLogPurchaseOrders($company_id, Request $request){
        $log_purchase_orders_query = PurchaseOrder::orderBy('purchase_date', 'desc')->whereHas('logs')->with('vendor');
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
            $log_purchase_orders_query->whereHas('vendor', function ($query) use($vendor_name){
                $query->where('name','like','%'.$vendor_name.'%');
            });
        }

        $log_purchase_orders_query->where($wheres);

        if ($request->item_per_page){
            $log_purchase_orders = $log_purchase_orders_query->paginate($request->item_per_page);
        }else{
            $log_purchase_orders = $log_purchase_orders_query->paginate(10);
        }

        return response()->json([
            'log_purchase_orders' => $log_purchase_orders,
        ], 200);
    }

    public function getJsonVendors($company_id){
        $vendors = Vendor::where('company_id','=',$company_id)->orderBy('name', 'asc')->get();
        return response()->json($vendors, 200);
    }

    public function getJsonCategories($company_id){
        $categories = Category::where('company_id','=',$company_id)->orderBy('name', 'asc')->get();
        return response()->json($categories, 200);
    }

    public function getJsonGrades($company_id){
        $grades = Grade::where('company_id','=',$company_id)->orderBy('name', 'asc')->get();
        return response()->json($grades, 200);
    }

    public function postJsonLogItem($company_id, Request $request){
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

                $log_item = new PurchaseOrderDetailLog();
                $log_item->purchase_order_id = $purchase_order->id;
                $log_item->height = $request->height;
                $log_item->radius = $request->radius;
                $log_item->grade = $request->grade;
                $log_item->price_per_unit = $request->price_per_unit;
                $log_item->company_id = $company_id;
                $log_item->challan_no_mannual = $purchase_order->challan_no_mannual;
                $log_item->category_id = $request->category_id;
                $log_item->save();
                $message = [
                    'status' => "success",
                    'message' => "Log item add successfully!",
                ];
                return response()->json([
                    'purchase_order' => $purchase_order,
                    'log_item' => $log_item,
                    'message' => $message,
                ], 200);

            }catch(Exception $e){
                $message = [
                    'status' => "danger",
                    'message' => "Something wrong! Try again.",
                ];
                return response()->json([
                    'message' => $message,
                ], 400);
            }

    }

    public function deleteJsonLogItem($company_id, $id){
        try{
            $logItem = PurchaseOrderDetailLog::where([
                ['company_id' , $company_id],
                ['id', $id],
            ])->first();
            $logItem->delete();
            $message = [
                'status' => "success",
                'message' => "Log item deleted successfully!",
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
                ])->first()->load('logs');

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

                $amount = 0;
                foreach ($purchase_order->logs as $k => $Log){
                    $logItem = PurchaseOrderDetailLog::find($Log->id);
                    $logItem->log_no = $k+1;
                    $logItem->save();
                    $amount = $amount + $logItem->total_price;
                }
                $purchase_order->amount = $amount;
                $purchase_order->due_amount = $amount;
                $purchase_order->status = 1;
                $purchase_order->saved_by = $request->_user_info['id'];
                $purchase_order->save();

                $redirect_route = route('logPurchaseOrders.index', ['company_id' => $company_id]);
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
        ])->with('vendor')->whereHas('logs')->get();
        return view('admin.purchase-order-log.drafts')->with('drafts', $drafts);
    }

    public function draft($company_id, $id){
        $draft = PurchaseOrder::where([
            ['id', $id],
            ['company_id', $company_id],
            ['status', 0],
            ['created_by', Auth::id()],
        ])->with('vendor')->with('logs')->first();
        return view('admin.purchase-order-log.draft')->with('draft', $draft);
    }

    public function deleteDraft($company_id, $id){
            $draft = PurchaseOrder::where([
                ['id', $id],
                ['company_id', $company_id],
                ['status', 0],
                ['created_by', Auth::id()],
            ])->first();

            if ($draft){
                $draft->logs()->delete();
                $draft->delete();

                return redirect()->back()->withSuccess('Draft Order has deleted successfully!');
            }else{
                return redirect()->back()->withWarning('Something is wrong! Please try again later.');
            }


    }

    public function show($company_id, $id){
        $log_purchase_order = PurchaseOrder::where([
            'company_id'    => $company_id,
            'id'            => $id,
            'status'        => 1,
        ])->firstOrFail();

        $data = PurchaseOrderDetailLog::where([
            ['company_id', $company_id],
            ['purchase_order_id', $log_purchase_order->id],
        ])->get()->groupBy('category_id')->map(function ($item){
            return $item->groupBy('grade');
        })->map(function ($item, $key){
            $category = Category::find($key);
            return [
                'category'  => $category,
                'data'      => $item
            ];
        });

        return view('admin.purchase-order-log.show')->with([
            'log_purchase_order'    => $log_purchase_order,
            'log_data'              => $data
        ]);
    }

    public function edit($company_id, $id){
        $log_purchase_order = PurchaseOrder::where([
            ['id', $id],
            ['company_id', $company_id],
        ])->with('vendor')->with('logs')->first();
        $log_purchase_order->status =0;
        $log_purchase_order->save();
        return view('admin.purchase-order-log.edit')->with('log_purchase_order', $log_purchase_order);
    }

    public function updateJsonPurchaseOrder($company_id, $id, Request $request){
        try{
            $purchase_order = PurchaseOrder::where([
                ['company_id' , $company_id],
                ['id', $id],
            ])->first()->load('logs');

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

            $amount = 0;
            foreach ($purchase_order->logs as $k => $Log){
                $logItem = PurchaseOrderDetailLog::find($Log->id);
                $logItem->log_no = $k+1;
                $logItem->save();
                $amount = $amount + $logItem->total_price;
            }
            $purchase_order->amount = $amount;
            $purchase_order->due_amount = $amount - $purchase_order->paid_amount;
            $purchase_order->status = 1;
            $purchase_order->updated_by = $request->_user_info['id'];
            $purchase_order->save();
            $redirect_route = route('logPurchaseOrders.index', ['company_id' => $company_id]);

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
            $purchase_order->logs()->delete();
            $purchase_order->delete();
            $message = [
                'status' => "success",
                'message' => "Success! Purchase Order has deleted.",
            ];
            $redirect_route = route('logPurchaseOrders.index', ['company_id' => $company_id]);
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

    public function getDownloadLogPurchaseOrder($company_id, $id){

        $company = Company::findOrFail($company_id);
        $log_purchase_order = PurchaseOrder::where([
            'company_id'    => $company_id,
            'id'            => $id,
            'status'        => 1,
        ])->firstOrFail();

        $data = PurchaseOrderDetailLog::where([
            ['company_id', $company_id],
            ['purchase_order_id', $log_purchase_order->id],
        ])->get()->groupBy('category_id')->map(function ($item){
            return $item->groupBy('grade');
        })->map(function ($item, $key){
            $category = Category::find($key);
            return [
                'category'  => $category,
                'data'      => $item
            ];
        });

        $pdf = PDF::loadView('pdf.log_purchase_order.show', [
            'company'           => $company,
            'log_purchase_order'    => $log_purchase_order,
            'log_data'              => $data
        ]);
        return $pdf->stream();
    }

    public function getDownloads($company_id, Request $request){
        $company = Company::find($company_id);
        $log_purchase_orders_query = PurchaseOrder::orderBy('purchase_date', 'desc')->whereHas('logs')->with('vendor');
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
            $log_purchase_orders_query->whereHas('vendor', function ($query) use($vendor_name){
                $query->where('name','like','%'.$vendor_name.'%');
            });
        }

        $log_purchase_orders_query->where($wheres);

        if ($request->item_per_page){
            $log_purchase_orders = $log_purchase_orders_query->paginate($request->item_per_page);
        }else{
            $log_purchase_orders = $log_purchase_orders_query->paginate(10);
        }


        $pdf = PDF::loadView('pdf.log_purchase_order.index', [
            'log_purchase_orders'    => $log_purchase_orders,
            'company'       => $company
        ]);
        return $pdf->stream();
    }
}
