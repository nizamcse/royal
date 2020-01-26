<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderDetailLog extends Model
{
    use SoftDeletes;
    use LogTrait;
    use CompanyTrait;
    protected $fillable = [
        'log_no',
        'purchase_order_id',
        'height',
        'radius',
        'grade',
        'quantity',
        'price_per_unit',
        'total_price',
        'new_height',
        'new_radius',
        'new_quantity',
        'wastage_quantity',
        'wastage_quantity_in_percent',
        'wastage_total_price',
        'challan_no_mannual',
        'production_id',
        'company_id',
        'category_id'
    ];

    protected $casts = [
        'height'            => 'double',
        'radius'            => 'double',
        'price_per_unit'    => 'double',
        'quantity'          => 'double',
        'total_price'       => 'double',
    ];

    public function purchaseOrder(){
        return $this->belongsTo('App\Model\PurchaseOrder', 'purchase_order_id', 'purchase_order_id');
    }

}
