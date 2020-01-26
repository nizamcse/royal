<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 04-Mar-19
 * Time: 10:58 AM
 */

namespace App\Traits;


use Carbon\Carbon;

trait ProductionTrait
{
    public static function ProductionTrait()
    {
        static::creating(function ($model) {
            dd("Hi");
            $in_time = Carbon::parse($model->start_at)->format('Y-m-d H:m:s');;
            $exit_time = Carbon::parse($model->end_at);
            $hours = $in_time->copy()->diffInHours($exit_time);
            $minutes = $in_time->copy()->addHours($hours)->diffInMinutes($exit_time);
            dd($model);
            $model->production_hour = $hours + $minutes/100;
        });
    }
}