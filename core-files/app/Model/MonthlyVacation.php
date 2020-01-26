<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class MonthlyVacation extends Model
{
    use CompanyTrait;
    protected $fillable = ['vacation_id','month','year','days'];
}
