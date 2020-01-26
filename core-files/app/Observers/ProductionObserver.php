<?php

namespace App\Observers;

use App\Model\Production;
use Carbon\Carbon;

class ProductionObserver
{
    public function creating(Production $production){
        $in_time = Carbon::parse($production->start_at);
        $exit_time = Carbon::parse($production->end_at);
        $hours = $in_time->copy()->diffInHours($exit_time);
        $minutes = $in_time->copy()->addHours($hours)->diffInMinutes($exit_time);
        $production->production_hour = $hours + $minutes/100;
    }
    /**
     * Handle the production "created" event.
     *
     * @param  \App\Model\Production  $production
     * @return void
     */
    public function created(Production $production)
    {
        //
    }

    /**
     * Handle the production "updated" event.
     *
     * @param  \App\Model\Production  $production
     * @return void
     */
    public function updated(Production $production)
    {
        //
    }

    /**
     * Handle the production "deleted" event.
     *
     * @param  \App\Model\Production  $production
     * @return void
     */
    public function deleted(Production $production)
    {
        //
    }

    /**
     * Handle the production "restored" event.
     *
     * @param  \App\Model\Production  $production
     * @return void
     */
    public function restored(Production $production)
    {
        //
    }

    /**
     * Handle the production "force deleted" event.
     *
     * @param  \App\Model\Production  $production
     * @return void
     */
    public function forceDeleted(Production $production)
    {
        //
    }
}
