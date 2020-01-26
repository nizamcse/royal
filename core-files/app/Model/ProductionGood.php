<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class ProductionGood extends Model
{
    use CompanyTrait;
    protected $fillable = ['produced_good_id','quantity','good_id','company_id'];

    public function producedGood(){
        return $this->belongsTo('App\Model\ProducedGood','produced_good_id','id');
    }

    public function good(){
        return $this->belongsTo('App\Model\Good','good_id','id');
    }
}
