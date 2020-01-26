<?php

namespace App\Http\Controllers;

use App\Model\PurchaseOrder;
use App\Model\RawMaterial;
use App\Model\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index($company_id){
        return view('admin.vendor.index');
    }


    public function getVendors($company_id, Request $request){

        $vendors_query = Vendor::where('company_id','=',$company_id)->orderBy('name','asc');
        $materials_query = RawMaterial::select(['id', 'name','unit_id'])->with(['unit']);
        if ($request->raw_material_id){
            $where = [
                ['raw_material_id', '=', $request->raw_material_id],
            ];
            $vendors_query->whereHas('PurchaseOrders', function ($query) use ($where){
                $query->WhereHas('rawMaterials', function ($query) use ($where){
                    $query->where($where);
                })->orWhereHas('otherMaterials', function ($query) use ($where){
                    $query->where($where);
                });
            });
        }
        else{
            if ($request->product_type == 1 ){
                $vendors_query->whereHas('PurchaseOrders', function ($query){
                    $query->whereHas('logs');
                });
            }elseif($request->product_type == 2){
                $vendors_query->whereHas('PurchaseOrders', function ($query){
                    $query->whereHas('rawMaterials');
                });
                $materials_query->whereHas('purchaseOrderDetail', function ($query){
                    $query->where('material_type', 1); //material_type 1 represent Raw Materials at purchase_order_details table;
                });
            }elseif($request->product_type == 3){
                $vendors_query->whereHas('PurchaseOrders', function ($query){
                    $query->whereHas('otherMaterials');
                });
                $materials_query->whereHas('purchaseOrderDetail', function ($query){
                    $query->where('material_type', 2); // material_type 2 represent Other Materials at purchase_order_details table;
                });
            }

        }

        $vendors = $vendors_query->paginate(10);
        $materials = $materials_query->get();


        return response()->json([
            'vendors' => $vendors,
            'materials' => $materials,
        ],200);

    }

    public function profile($company_id,$vendor_id){
        $vendor = Vendor::where([
            ['company_id', $company_id],
            ['id', $vendor_id],
            ])->with(['PurchaseOrders' => function ($query){
                $query->orderBy('purchase_date', 'desc');
        }])->firstOrFail();

        $vendor_total_purchase_number = PurchaseOrder::where([
            ['company_id', $company_id],
            ['vendor_id', $vendor_id],
            ])->count();
        $vendor_total_purchase_amount = PurchaseOrder::where([
            ['company_id', $company_id],
            ['vendor_id', $vendor_id],
        ])->sum('amount');
        $vendor_total_purchase_paid_amount = PurchaseOrder::where([
            ['company_id', $company_id],
            ['vendor_id', $vendor_id],
        ])->sum('paid_amount');
        $vendor_total_purchase_due_amount = PurchaseOrder::where([
            ['company_id', $company_id],
            ['vendor_id', $vendor_id],
        ])->sum('due_amount');

        return view('admin.vendor.purchase-orders')->with([
            'vendor' => $vendor,
            'vendor_total_purchase_number' => $vendor_total_purchase_number,
            'vendor_total_purchase_amount' => $vendor_total_purchase_amount,
            'vendor_total_purchase_paid_amount' => $vendor_total_purchase_paid_amount,
            'vendor_total_purchase_due_amount' => $vendor_total_purchase_due_amount,
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
            'contact_no'  => 'required',
            'address'  => 'required',
        ]);
        Vendor::create($request->all());
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created vendor.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        $this->validate($request,[
            'name'  => 'required',
            'contact_no'  => 'required',
            'address'  => 'required',
        ]);
        Vendor::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name','contact_no','address'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated vendor.'
        ]);
    }
    public function delete($company_id,$id){
        Vendor::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted vendor.'
        ]);
    }
}
