<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class SalesChalanDetail extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'chalan_id',
        'sales_order_details_id',
        'good_id',
        'received_qty',
        'goods_amount',
        'company_id'
    ];

    public function chalan(){
        return $this->belongsTo('App\Model\SalesChalan','chalan_id','id');
    }

    public function good(){
        return $this->belongsTo('App\Model\Good','good_id','id');
    }
}
