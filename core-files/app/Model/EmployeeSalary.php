<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use CompanyTrait;
    protected $fillable = ['employee_id','company_id','month','year','basic_salary','bonuses_amount','deductions_amount','funds_amount','net_salary','status'];

    public function employee(){
        return $this->belongsTo('App\Model\Employee','employee_id','id');
    }
}
