<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','company_id'];

    public function users(){
        return $this->belongsToMany('App\User','user_roles','role_id','user_id')
            ->withTimestamps();
    }

    public function permissions(){
        return $this->belongsToMany('App\Model\Permission','role_permissions','role_id','permission_id')
            ->withTimestamps();
    }
}
