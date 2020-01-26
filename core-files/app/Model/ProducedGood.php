<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class ProducedGood extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'production_id','good_id','produced_quantity','released_quantity','remaining_quantity','company_id','produced_goods_value','unit_price'
    ];

    public function good(){
        return $this->belongsTo('App\Model\Good','good_id','id');
    }
}
