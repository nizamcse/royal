<?php
/**
 * Created by PhpStorm.
 * User: fahadseraj
 * Date: 12/6/2018 AD
 * Time: 2:06 PM
 */

namespace App\Traits;


use Illuminate\Support\Facades\Auth;

trait BranchAttachTrait
{
    public static function bootBranchAttachTrait()
    {
        static::creating(function ($model) {
            $model->branch_who_created = Auth::user()->branch_id;
        });
    }

    public function branch(){
        return $this->belongsTo('App\Model\Branch','branch_who_created','id');
    }

    public function branchName(){
        return $this->branch ? $this->branch->name: "";
    }
}