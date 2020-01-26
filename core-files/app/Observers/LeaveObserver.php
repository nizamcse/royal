<?php

namespace App\Observers;

use App\Model\Leave;
use App\Model\MonthlyLeave;
use Carbon\Carbon;

class LeaveObserver
{
    /**
     * Handle the leave "creating" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */

    public function creating(Leave $leave){
        $to_date = Carbon::parse($leave->to_date);
        $from_date = Carbon::parse($leave->from_date);
        $leave->allowed_days = $to_date->diffInDays($from_date) + 1;
    }
    /**
     * Handle the leave "created" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */
    public function created(Leave $leave)
    {

    }

    public function updating(Leave $leave){
        $to_date = Carbon::parse($leave->to_date);
        $from_date = Carbon::parse($leave->from_date);
        $leave->allowed_days = $to_date->diffInDays($from_date) + 1;
    }

    /**
     * Handle the leave "updated" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */
    public function updated(Leave $leave)
    {
        //
    }

    /**
     * Handle the leave "deleting" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */

    public function deleting(Leave $leave){
        $monthly_leaves = MonthlyLeave::where([
            'leave_id'  => $leave->id
        ])->get();
        foreach ($monthly_leaves as $monthly_leave){
            $monthly_leave->delete();
        }
    }

    /**
     * Handle the leave "deleted" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */
    public function deleted(Leave $leave)
    {

    }

    /**
     * Handle the leave "restored" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */
    public function restored(Leave $leave)
    {
        //
    }

    /**
     * Handle the leave "force deleted" event.
     *
     * @param  \App\Model\Leave  $leave
     * @return void
     */
    public function forceDeleted(Leave $leave)
    {
        //
    }
}
