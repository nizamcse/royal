<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','address','contact_no','email','logo','end_month','start_month'];

    public function users(){
        return $this->belongsToMany('App\User','company_users','company_id','user_id')
            ->withPivot('is_admin')->withTimestamps();
    }

    public function admin(){
        return $this->belongsToMany('App\User','company_users','company_id','user_id')
            ->wherePivot('is_admin','=',1)->withPivot('is_admin')->withTimestamps();
    }

    public function getLogoAttribute($logo){
        return asset($logo);
    }
}
