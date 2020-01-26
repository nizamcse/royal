<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Config;

class AccountStatementController extends Controller
{
    public function index(){
        return view('admin.report.account-statements');
    }

    public function getStatements(Request $request,$company_id){
        $account_type = $request->account_type;
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $to_date   = Carbon::parse($request->to_date)->format('Y-m-d');
        $journals = Journal::where('company_id','=',$company_id)
            ->whereHas('account',function($query) use($account_type){
                $query->where('type','=',$account_type);
            })->whereBetween('journal_date',[$from_date,$to_date])->get();

        // Initializing Balance
        $balance = 0;
        // Initializing statements
        $statements = [];

        foreach($journals as $k => $journal){
            $statements[$k]['journal_date'] = $journal->journal_date;
            $statements[$k]['account']      = $journal->journal->account ? $journal->journal->account->name : '';
            $statements[$k]['narration']    = $journal->journalEntry->narration ?? '';
            if($journal->account_type){
                $balance -= $journal->credit;
                $statements[$k]['debit']    = number_format(0,2);
                $statements[$k]['credit']   = number_format($journal->credit,2);
                $statements[$k]['balance']  = number_format($balance,2);
                $statements[$k]['status']   = false; // Balance decreased
            }else{
                $balance += $journal->debit;
                $statements[$k]['debit']    = number_format($journal->debit,2);
                $statements[$k]['credit']   = number_format(0,2);
                $statements[$k]['balance']  = number_format($balance,2);
                $statements[$k]['status']   = true; // Balance increased
            }
        }

        return response()->json($statements,200);
    }

    public function downloadStatements(Request $request,$company_id){
        $this->validate($request,[
            'account_type'  => ['required'],
            'from_date'     => ['required'],
            'to_date'       => ['required'],
        ]);
        $account_type = $request->account_type;
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $to_date   = Carbon::parse($request->to_date)->format('Y-m-d');
        $journals = Journal::where('company_id','=',$company_id)
            ->whereHas('account',function($query) use($account_type){
                $query->where('type','=',$account_type);
            })->whereBetween('journal_date',[$from_date,$to_date])->get();
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.account-statements', [
            'account_type'    => Config::get('enums.account_types')[$request->account_type] ?? 'Unknown',
            'from_date'       => $from_date,
            'to_date'         => $to_date,
            'journals'        => $journals,
            'company'         => $company
        ]);
        return $pdf->stream();
    }
}
