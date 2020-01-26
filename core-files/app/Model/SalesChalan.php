<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class SalesChalan extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'sales_order_id',
        'chalan_date',
        'chalan_no',
        'chalan_no_manual',
        'type',
        'company_id'
    ];

    public function salesOrder(){
        return $this->belongsTo('App\Model\SalesOrder','sales_order_id','id');
    }
    public function details(){
        return $this->hasMany('App\Model\SalesChalanDetail','chalan_id','id');
    }

    public function itemDetails(){
        return $this->hasMany('App\Model\PurchaseSalesChalanDetail','chalan_id','id');
    }

}
