<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class SalesPaymentField extends Model
{
    use CompanyTrait;
    protected $fillable = ['field_value','sales_payment_id','payment_type_field_id','company_id'];
}
