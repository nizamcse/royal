<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveType extends Model
{
    use CompanyTrait;
    protected $fillable = ['employee_id','leave_type_id','max_allowed_days','company_id'];
}
