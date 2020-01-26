<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Route;

class SummaryType extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name', 'company_id'];

    public function scopeCompany($query){
        $parameters = Route::current()->parameters();
        $query->where('company_id',$parameters['company_id']);
    }
}
