<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'start_at','end_at','good_produced','comment','total_labour','total_labour_cost','utility_cost','other_cost','total_production_cost','company_id','status','production_hour'
    ];

    public function producedGoods(){
        return $this->hasMany('App\Model\ProducedGood','production_id','id');
    }

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setGoodProducedAttribute($value){
        $this->attributes['good_produced'] = $value ? 0 : 1;
    }
}
