<?php

namespace App\Observers;

use App\Model\MonthlyVacation;
use App\Model\Vacation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class VacationObserver
{
    /**
     * Handle the vacation "creating" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */

    public function creating(Vacation $vacation){
        $from = Carbon::parse($vacation->from_date)->format('Y-m-d');
        $to = Carbon::parse($vacation->to_date)->format('Y-m-d');
        $period = CarbonPeriod::create($from, $to);
        $vacation->allowed_days = $period->count();
    }
    /**
     * Handle the vacation "created" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */
    public function created(Vacation $vacation)
    {
        $from = Carbon::parse($vacation->from_date)->format('Y-m-d');
        $to = Carbon::parse($vacation->to_date)->format('Y-m-d');
        $period = CarbonPeriod::create($from, $to);
        $dates = collect($period)->groupBy(function($date){
            return $date->format('Y');
        })->map(function ($item){
            return $item->groupBy(function($d){
                return $d->format('m');
            })->map(function($item){
                return $item->count();
            });
        });
        foreach ($dates as $year => $months){
            foreach ($months as $month => $days){
                MonthlyVacation::create([
                    'vacation_id'  => $vacation->id,
                    'year'      => $year,
                    'month'     => $month,
                    'days'      => $days,
                ]);
            }
        }
    }

    /**
     * Handle the vacation "updating" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */

    public function updating(Vacation $vacation){
        $from = Carbon::parse($vacation->from_date)->format('Y-m-d');
        $to = Carbon::parse($vacation->to_date)->format('Y-m-d');
        $period = CarbonPeriod::create($from, $to);
        $vacation->allowed_days = $period->count();
    }

    /**
     * Handle the vacation "updated" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */
    public function updated(Vacation $vacation)
    {
        $from = Carbon::parse($vacation->from_date)->format('Y-m-d');
        $to = Carbon::parse($vacation->to_date)->format('Y-m-d');
        $period = CarbonPeriod::create($from, $to);
        $dates = collect($period)->groupBy(function($date){
            return $date->format('Y');
        })->map(function ($item){
            return $item->groupBy(function($d){
                return $d->format('m');
            })->map(function($item){
                return $item->count();
            });
        });

        MonthlyVacation::where('vacation_id','=',$vacation->id)->delete();

        foreach ($dates as $year => $months){
            foreach ($months as $month => $days){
                MonthlyVacation::create([
                    'vacation_id'  => $vacation->id,
                    'year'      => $year,
                    'month'     => $month,
                    'days'      => $days,
                ]);
            }
        }
    }

    /**
     * Handle the vacation "deleted" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */
    public function deleted(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the vacation "restored" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */
    public function restored(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the vacation "force deleted" event.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return void
     */
    public function forceDeleted(Vacation $vacation)
    {
        //
    }
}
