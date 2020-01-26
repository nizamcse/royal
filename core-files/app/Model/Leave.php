<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use CompanyTrait;
    protected $fillable = ['employee_id','leave_type_id','from_date','to_date','company_id'];
    public function employee(){
        return $this->belongsTo('App\Model\Employee','employee_id','id');
    }

    public function monthlyLeaves(){
        return $this->hasMany('App\Model\MonthlyLeave','leave_id','id');
    }
}
