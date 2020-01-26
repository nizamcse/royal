<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentTypeField extends Model
{
    protected $fillable = ['name','payment_type_id','company_id'];
}
