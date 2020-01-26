<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPayment extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['sales_order_id', 'so_no_manual', 'payment_type_id','amount','payment_date','company_id'];

    public function paymentType(){
        return $this->belongsTo('App\Model\PaymentType','payment_type_id','id');
    }

    public function fields(){
        return $this->belongsToMany('App\Model\PaymentTypeField','sales_payment_fields','sales_payment_id','payment_type_field_id')
            ->withPivot('field_value')->withTimestamps();
    }

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
