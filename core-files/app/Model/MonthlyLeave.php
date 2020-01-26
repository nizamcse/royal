<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class MonthlyLeave extends Model
{
    use CompanyTrait;
    protected $fillable = ['leave_id','month','year','days'];

    public function leave(){
        return $this->belongsTo('App\Model\Leave','leave_id','id');
    }
}
