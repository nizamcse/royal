<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class AccountClosing extends Model
{
    use CompanyTrait;
    protected $fillable = [
        'closing_start_year',
        'closing_end_year',
        'closing_start_from',
        'closing_ends_at',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User','created_by','id')->references('id')->on('users');
    }
}
