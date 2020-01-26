<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name','contact_no','address','company_id'];

    public function salesOrder(){
        return $this->hasMany('App\Model\SalesOrder', 'customer_id', 'id');
    }
}
