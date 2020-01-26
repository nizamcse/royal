<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderDetail extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = [
        'purchase_order_id',
        'raw_material_id',
        'unit_id',
        'quantity',
        'returned_quantity',
        'used_quantity',
        'wasted_quantity',
        'sold_quantity',
        'remaining_quantity',
        'price_per_unit',
        'inventory_item_id',
        'amount',
        'material_type',
        'challan_no_mannual',
        'company_id'
    ];

    protected $appends = ['name','unit_name'];

    public function rawMaterial(){
        return $this->belongsTo('App\Model\RawMaterial','raw_material_id','id');
    }

    public function materialName(){
        return $this->rawMaterial ? $this->rawMaterial->name : '';
    }

    public function unit(){
        return $this->belongsTo('App\Model\Unit','unit_id','id');
    }

    public function inventoryItem(){
        return $this->belongsTo('App\Model\InventoryItem','inventory_item_id','id');
    }

    public function getUnitNameAttribute(){
        return $this->unit ? $this->unit->name : '';
    }

    public function getNameAttribute(){
        $item = $this->inventoryItem;

        if(!$item){
            return "";
        }

        if($item->type ==2){
            return $item->materialName(). ' Thickness: '.$item->thickness.' Size: '.$item->size;
        }
        return $item->materialName();
    }
}
