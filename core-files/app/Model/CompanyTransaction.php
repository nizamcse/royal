<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyTransaction extends Model
{
    protected $fillable = ['from','to','journal_entry_id_from','journal_entry_id_to','status','amount'];

    public function sender(){
        return $this->belongsTo('App\Model\Company','from','id');
    }

    public function receiver(){
        return $this->belongsTo('App\Model\Company','to','id');
    }

    public function journalFrom(){
        return $this->belongsTo('App\Model\JournalEntry','journal_entry_id_from','id');
    }
    public function journalTo(){
        return $this->belongsTo('App\Model\JournalEntry','journal_entry_id_to','id');
    }
}
