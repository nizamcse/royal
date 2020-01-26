<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'name',
        'contact_no',
        'address',
        'sold_out_date',
        'status',
        'total_amount',
        'paid_amount',
        'due_amount',
        'return_product_amount',
        'customer_id',
        'company_id',
        'other_charge',
        'payable_amount',
        'so_no_manual',
        'type',
        'additional_so_no_manual',
        'total_discount',
    ];

    public function customer(){
        return $this->belongsTo('App\Model\Customer', 'customer_id', 'id');
    }

    public function details(){
        return $this->hasMany('App\Model\ProductTransition','order_id','id');
    }

    public function purchaseSalesDetails(){
        return $this->hasMany('App\Model\ProductTransition','order_id','id');
    }

    public function setSoldOutDateAttribute($value)
    {
        $this->attributes['sold_out_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function salesOrderOtherChargeDetails(){
      return  $this->hasMany('App\Model\SalesOrderOtherChargeDetail', 'sales_order_id', 'id');
    }
}
