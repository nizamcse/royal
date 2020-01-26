<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseSalesChalanDetail extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'chalan_id',
        'purchase_sales_detail_id',
        'inventory_item_id',
        'received_qty',
        'goods_amount',
        'company_id'
    ];

    public function chalan(){
        return $this->belongsTo('App\Model\SalesChalan','chalan_id','id');
    }

    public function inventoryItem(){
        return $this->belongsTo('App\Model\InventoryItem','inventory_item_id','id');
    }
}
