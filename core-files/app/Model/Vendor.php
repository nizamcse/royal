<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name','contact_no','address','company_id'];

    public function PurchaseOrders(){
        return $this->hasMany('App\Model\PurchaseOrder', 'vendor_id', 'id');
    }
}
