<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name','slug'];
    public function roles(){
        return $this->belongsToMany('App\Model\Role','role_permissions','permission_id','role_id')
            ->withTimestamps();
    }
}
