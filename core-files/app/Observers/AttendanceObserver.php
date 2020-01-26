<?php

namespace App\Observers;

use App\Model\Attendance;
use App\Model\Employee;
use Carbon\Carbon;

class AttendanceObserver
{
    /**
     * Handle the attendance "creating" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */
    public function creating(Attendance $attendance)
    {
        $in_time = Carbon::parse($attendance->in_time);
        $exit_time = Carbon::parse($attendance->exit_time);
        //$diff_in_hour = $exit_time->diffInHours($in_time);
        /**
         * Renew Code
         */

        $hours = $in_time->copy()->diffInHours($exit_time);
        $minutes = $in_time->copy()->addHours($hours)->diffInMinutes($exit_time);

        if($minutes > 30){
            $hours+= 1;
        }

        $employee = Employee::where([
            ['company_id','=', $attendance->company_id,],
            ['id','=',$attendance->employee_id]
        ])->firstOrFail();
        $working_hour = $hours + ($minutes / 100);
        $attendance->measurement_quantity = $working_hour;
        $total_wage = $working_hour * $employee->salary;
        if($employee->salary_type ==1){
            $attendance->total_wage = $total_wage;
            $attendance->net_wage = $total_wage;
        }

        if($employee->minimum_working_hour < $working_hour){
            $overtime = $working_hour - $employee->minimum_working_hour;
            $attendance->overtime = $overtime;
            $overtime_wage = $overtime * $employee->salary;
            if($employee->salary_type ==1){
                $attendance->overtime_wage = $overtime_wage;
                $attendance->net_wage = $total_wage + $overtime_wage;
            }
        }
    }

    /**
     * Handle the attendance "updating" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */

    public function updating(Attendance $attendance)
    {
        $in_time = Carbon::parse($attendance->in_time);
        $exit_time = Carbon::parse($attendance->exit_time);
        //$diff_in_hour = $exit_time->diffInHours($in_time);
        /**
         * Renew Code
         */

        $hours = $in_time->copy()->diffInHours($exit_time);
        $minutes = $in_time->copy()->addHours($hours)->diffInMinutes($exit_time);

        if($minutes > 30){
            $hours+= 1;
        }

        $employee = Employee::where([
            ['company_id','=', $attendance->company_id,],
            ['id','=',$attendance->employee_id]
        ])->firstOrFail();
        $working_hour = $hours + ($minutes / 100);
        $attendance->measurement_quantity = $working_hour;
        $total_wage = $working_hour * $employee->salary;
        if($employee->salary_type ==1){
            $attendance->total_wage = $total_wage;
            $attendance->net_wage = $total_wage;
        }

        if($employee->minimum_working_hour < $working_hour){
            $overtime = $working_hour - $employee->minimum_working_hour;
            $attendance->overtime = $overtime;
            $overtime_wage = $overtime * $employee->salary;
            if($employee->salary_type ==1){
                $attendance->overtime_wage = $overtime_wage;
                $attendance->net_wage = $total_wage + $overtime_wage;
            }
        }
    }

    /**
     * Handle the attendance "created" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */
    public function created(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "updated" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */
    public function updated(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "deleted" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */
    public function deleted(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "restored" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */
    public function restored(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "force deleted" event.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return void
     */
    public function forceDeleted(Attendance $attendance)
    {
        //
    }
}
