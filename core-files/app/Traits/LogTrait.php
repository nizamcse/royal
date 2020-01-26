<?php
/**
 * Created by PhpStorm.
 * User: fahadseraj
 * Date: 12/16/2018 AD
 * Time: 11:36 PM
 */

namespace App\Traits;


trait LogTrait
{
    public static function bootLogTrait()
    {
        static::creating(function ($model) {
            $r = $model->radius;
            $h = $model->height;
            $q = ($r * $r * $h) / 2304;
            $p = $model->price_per_unit;
            $tp = $q * $p;

            $model->quantity    = $q;
            $model->total_price = $tp;


        });

        static::updating(function ($model){
            if($model->production_id) {
                $nr = $model->new_radius ? $model->new_radius : 0;
                $nh = $model->new_height ? $model->new_height : 0;
                $nq = ($nr * $nr * $nh) / 2304;
                $q = $model->quantity;
                $wq = $q - $nq;
                $wtp = $model->price_per_unit * $wq;
                $w_percentage = ( $wq * 100 ) / $q;
                $model->new_quantity    = $nq;
                $model->wastage_quantity    = $wq;
                $model->wastage_quantity_in_percent    = $w_percentage;
                $model->wastage_total_price    = $wtp;
            }
        });
    }

}