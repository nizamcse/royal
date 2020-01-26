<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseHead extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name','company_id'];
}
