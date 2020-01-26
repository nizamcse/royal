<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseSalesDetail extends Model
{
    use CompanyTrait;
    protected $fillable = ['sales_order_id','inventory_item_id','po_detail_id','unit_id','unit_price','sub_total','quantity','discount','delivered_quantity','remaining_quantity','returned_quantity','company_id','base_price'];
    protected $appends = ['received_quantity'];

    public function inventoryItem(){
        return $this->belongsTo('App\Model\InventoryItem','inventory_item_id','id');
    }

    public function unit(){
        return $this->belongsTo('App\Model\Unit','unit_id','id');
    }

    public function purchaseOrderDetail(){
        return $this->belongsTo('App\Model\PurchaseOrderDetail','po_detail_id','id');
    }

    public function getReceivedQuantityAttribute(){
        return $this->delivered_quantity - $this->returned_quantity;
    }
}
