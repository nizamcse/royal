<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = [
        'employee_id',
        'attendance_date',
        'in_time',
        'exit_time',
        'overtime',
        'shift',
        'measurement_quantity',
        'total_wage',
        'overtime_wage',
        'net_wage',
        'company_id'
    ];

    public function employee(){
        return $this->belongsTo('App\Model\Employee','employee_id','id');
    }
}
