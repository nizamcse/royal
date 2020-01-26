<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['min_radius','max_radius','name','price_per_unit','category_id','company_id'];

    public function category(){
        return $this->belongsTo('App\Category','category_id','id');
    }
}
