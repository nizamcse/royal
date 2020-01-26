<?php

namespace App\Model;

//use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //use CompanyTrait;
    protected $fillable = ['name','slug','company_id','type'];

    public function journals(){
        return $this->hasMany('App\Model\Journal','account_id','id');
    }

    public function debits(){
        return $this->journals->where('account_type','=',1);
    }

    public function credits(){
        return $this->journals->where('account_type','=',0);
    }

    public function setSlugAttribute($value){
        $this->attributes['slug']   = str_slug($value,'-');
    }
}
