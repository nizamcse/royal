<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use CompanyTrait;
    protected $fillable = ['narration','journal_date','status','company_id'];

    protected $appends = ['debit_row','credit_row'];

    public function debited(){
        return $this->hasMany('App\Model\Journal','journal_entry_id','id')->where([
            'account_type'  => 0
        ]);
    }

    public function credited(){
        return $this->hasMany('App\Model\Journal','journal_entry_id','id')->where([
            'account_type'  => 1
        ]);
    }

    public function  getDebitRowAttribute(){
        return $this->debited->first();
    }
    public function  getCreditRowAttribute(){
        return $this->credited->first();
    }

    public function setJournalDateAttribute($value)
    {
        $this->attributes['journal_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
