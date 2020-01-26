<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['expense_head_id','amount','comment','expense_date','company_id'];

    public function head(){
        return $this->belongsTo('App\Model\ExpenseHead','expense_head_id','id');
    }

    public function setExpenseDateAttribute($value)
    {
        $this->attributes['expense_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
