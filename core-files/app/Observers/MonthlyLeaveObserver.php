<?php

namespace App\Observers;

use App\Model\EmployeeAnnualLeave;
use App\Model\MonthlyLeave;

class MonthlyLeaveObserver
{
    /**
     * Handle the monthly leave "created" event.
     *
     * @param  \App\Model\MonthlyLeave  $monthlyLeave
     * @return void
     */
    public function created(MonthlyLeave $monthlyLeave)
    {
        $leave = $monthlyLeave->leave;
        $annual_leave = EmployeeAnnualLeave::firstOrCreate([
            'employee_id'   => $leave->employee_id,
            'leave_type_id' => $leave->leave_type_id,
            'year'          => $monthlyLeave->year
        ]);

        $taken_leave_days = $annual_leave->taken_leave_days + $monthlyLeave->days;
        $annual_leave->fill([
            'taken_leave_days'  => $taken_leave_days
        ])->save();
    }

    /**
     * Handle the monthly leave "updated" event.
     *
     * @param  \App\Model\MonthlyLeave  $monthlyLeave
     * @return void
     */
    public function updated(MonthlyLeave $monthlyLeave)
    {

    }

    public function deleting(MonthlyLeave $monthlyLeave){

    }

    /**
     * Handle the monthly leave "deleted" event.
     *
     * @param  \App\Model\MonthlyLeave  $monthlyLeave
     * @return void
     */
    public function deleted(MonthlyLeave $monthlyLeave)
    {
        $leave = $monthlyLeave->leave;
        $annual_leave = EmployeeAnnualLeave::where([
            'employee_id'   => $leave->employee_id,
            'leave_type_id' => $leave->leave_type_id,
            'year'          => $monthlyLeave->year
        ])->firstOrFail();

        $taken_leave_days = $annual_leave->taken_leave_days - $monthlyLeave->days;
        $annual_leave->update([
            'taken_leave_days'  => $taken_leave_days
        ]);
    }

    /**
     * Handle the monthly leave "restored" event.
     *
     * @param  \App\Model\MonthlyLeave  $monthlyLeave
     * @return void
     */
    public function restored(MonthlyLeave $monthlyLeave)
    {
        //
    }

    /**
     * Handle the monthly leave "force deleted" event.
     *
     * @param  \App\Model\MonthlyLeave  $monthlyLeave
     * @return void
     */
    public function forceDeleted(MonthlyLeave $monthlyLeave)
    {
        //
    }
}
