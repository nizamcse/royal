<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    use CompanyTrait;
    protected $fillable = ['sales_order_id','good_id','unit_id','unit_price','sub_total','quantity','discount','delivered_quantity','remaining_quantity','returned_quantity','company_id','base_price'];
    protected $appends = ['received_quantity'];
    public function good(){
        return $this->belongsTo('App\Model\Good','good_id','id');
    }

    public function unit(){
        return $this->belongsTo('App\Model\Unit','unit_id','id');
    }

    public function getReceivedQuantityAttribute(){
        return $this->delivered_quantity - $this->returned_quantity;
    }

    public function salesOrder(){
        return $this->belongsTo('App\Model\SalesOrder', 'sales_order_id', 'id');
    }
}
