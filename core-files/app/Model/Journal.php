<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use CompanyTrait;
    protected $fillable = ['journal_date','account_id','journal_id','debit','credit','account_type','journal_entry_id','company_id'];

    public function account(){
        return $this->belongsTo('App\Model\Account','account_id','id');
    }

    public function journal(){
        return $this->belongsTo('App\Model\Journal','journal_id','id');
    }

    public function journalEntry(){
        return $this->belongsTo('App\Model\JournalEntry','journal_entry_id','id');
    }


}
