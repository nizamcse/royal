<?php
/**
 * Created by PhpStorm.
 * User: fahadseraj
 * Date: 1/20/2019 AD
 * Time: 11:48 AM
 */

namespace App\Traits;
use Route;


trait CompanyTrait
{

    public static function bootCompanyTrait()
    {
        static::creating(function ($model) {
            $parameters = Route::current()->parameters();
            if(isset($parameters['company_id'])){
                $model->company_id = $parameters['company_id'];
            }
        });
    }

}
