<?php

namespace App\Http\Controllers;

use App\Model\InventoryItem;
use App\Model\ProductionProduct;
use App\Model\PurchaseOrder;
use App\Model\PurchaseOrderDetailLog;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function rawMaterials($company_id){
        $raw_materials = InventoryItem::with(['rawMaterial','unit'])->where('type','=',1)
            ->where('company_id','=',$company_id)->get();
        return view('admin.inventory.raw-materials')->with([
            'raw_materials' => $raw_materials
        ]);
    }

    public function otherMaterials($company_id){
        $other_materials = InventoryItem::where('type','=',2)
            ->where('company_id','=',$company_id)->get();
        return view('admin.inventory.other-materials')->with([
            'other_materials' => $other_materials
        ]);
    }

    public function productionProducts($company_id){
        $production_goods = ProductionProduct::where('company_id','=',$company_id)->get();
        return view('admin.inventory.production-goods')->with([
            'production_goods'  => $production_goods
        ]);
    }

    public function logs($company_id){
        $purchase_orders = PurchaseOrder::with('logs')
            ->whereHas('logs')
            ->where('company_id','=',$company_id)->get();
        return view('admin.inventory.log')->with([
            'purchase_orders'  => $purchase_orders
        ]);
    }
}
