<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class SalesOrderOtherChargeDetail extends Model
{
    use CompanyTrait;

    public function salesOrder(){
        return $this->belongsTo('App\Model\SalesOrder', 'sales_order_id', 'id');
    }
}
