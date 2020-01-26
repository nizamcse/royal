<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'name',
        'present_address',
        'permanent_address',
        'nid',
        'photo',
        'contact_no',
        'email',
        'designation_id',
        'in_time',
        'exit_time',
        'shift',
        'salary',
        'salary_type',
        'minimum_working_hour',
        'company_id',
        'weekends'
    ];

    protected $casts = [
        'weekends' => 'array',
    ];

    protected $appends = ['salary_base'];

    public function rosters(){
        return $this->hasMany('App\Model\Roster','employee_id','id');
    }

    public function leaves(){
        return $this->hasMany('App\Model\Leave','employee_id','id');
    }

    public function leaveTypes(){
        return $this->belongsToMany('App\Model\LeaveType','employee_leave_types','employee_id','leave_type_id')
            ->withPivot('max_allowed_days')->withTimestamps();
    }

    public function annualLeaves(){
        return $this->belongsToMany('App\Model\EmployeeAnnualLeave','employee_leave_types','employee_id','leave_type_id')
            ->withPivot('max_allowed_days')->withTimestamps();
    }

    protected function getSalaryBaseAttribute(){
        $salary_types = ['Hourly','Monthly'];
        return $salary_types[$this->salary_type -1] ?? '';
    }


}
