<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class PurchasePaymentField extends Model
{
    use CompanyTrait;
    protected $fillable = ['field_value','purchase_payment_id','payment_type_field_id','company_id'];
}
