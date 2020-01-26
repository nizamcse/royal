<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentType extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name','company_id'];

    public function fields(){
        return $this->hasMany('App\Model\PaymentTypeField','payment_type_id','id');
    }
}
