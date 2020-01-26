<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class ProductionProduct extends Model
{
    use CompanyTrait;
    protected $fillable = ['good_id','quantity','company_id'];

    public function good(){
        return $this->belongsTo('App\Model\Good','good_id','id');
    }
}
