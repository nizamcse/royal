<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use CompanyTrait;
    protected $fillable = ['name','from_date','to_date','allowed_days','company_id'];

    public function setFromDateAttribute($value)
    {
        $this->attributes['from_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setToDateAttribute($value)
    {
        $this->attributes['to_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
