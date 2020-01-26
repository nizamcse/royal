<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'production_id',
        'raw_material_id',
        'unit_id',
        'inventory_item_id',
        'purchase_order_detail_id',
        'quantity',
        'wasted_quantity',
        'used_quantity',
        'price_per_unit',
        'thickness',
        'size',
        'amount',
        'challan_no_mannual',
    ];
}
