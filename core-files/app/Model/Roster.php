<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable = ['employee_id','in_time','exit_time','shift','roster_date','job_details','minimum_working_hour'];

    public function setRosterDateAttribute($value)
    {
        $this->attributes['roster_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
