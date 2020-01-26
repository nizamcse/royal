<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class EmployeeAnnualLeave extends Model
{
    use CompanyTrait;
    protected $fillable = ['employee_id','leave_type_id','year','taken_leave_days','company_id'];
}
