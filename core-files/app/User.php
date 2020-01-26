<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','super_admin','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function companies(){
        return $this->belongsToMany('App\Model\Company','company_users','user_id','company_id')
            ->withPivot('is_admin')->withTimestamps();
    }

    public function roles(){
        return $this->belongsToMany('App\Model\Role','user_roles','user_id','role_id')
            ->withTimestamps();
    }

    public function companyRole($company_id){
        $role = $this->roles->where('company_id','=',$company_id)->first();
        return $role ? $role->name : '';
    }

    public function role($company_id){
        return $this->roles->where('company_id','=',$company_id)->first();
    }
}
