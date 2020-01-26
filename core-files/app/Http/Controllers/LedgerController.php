<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Company;
use App\Model\Journal;
use Illuminate\Http\Request;
use PDF;

class LedgerController extends Controller
{
    public function getLedger($company_id,$account_id){
        ini_set('max_execution_time', 2000);
        ini_set('memory_limit', '512M');
        $account = Account::where([
            ['id','=',$account_id],
            ['company_id','=',$company_id],
        ])->firstOrFail();
        $journals = Journal::with(['journal.account','journalEntry'])->where('company_id','=',$company_id)
            ->where('account_id','=',$account_id)->orderBy('journal_date','ASC')->get();
        return view('admin.ledger.show')->with([
            'journals'  => $journals,
            'account'   => $account
        ]);
    }

    public function download($company_id,$account_id){
        ini_set('max_execution_time', 2000);
        ini_set('memory_limit', '512M');
        $account = Account::where([
            ['id','=',$account_id],
            ['company_id','=',$company_id],
        ])->firstOrFail();
        $journals = Journal::with(['journal.account','journalEntry'])->where('company_id','=',$company_id)
            ->where('account_id','=',$account_id)->orderBy('journal_date','ASC')->get();
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.ledger', [
            'journals'  => $journals,
            'company'   => $company,
            'account'   => $account
        ]);
        return $pdf->stream();
    }
}
