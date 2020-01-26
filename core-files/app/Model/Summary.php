<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Route;

class Summary extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['summary_type_id','summary_data','receive','payment','balance', 'comment', 'company_id'];
    protected $dates = ['summary_data'];


    public function summeryType()
    {
        return $this->belongsTo('App\Model\SummaryType', 'summary_type_id', 'id');
    }
    public function scopeCompany($query){
        $parameters = Route::current()->parameters();
        $query->where('company_id',$parameters['company_id']);
    }
}
