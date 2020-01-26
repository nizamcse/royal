<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Company;
use App\Model\CompanyTransaction;
use App\Model\Journal;
use App\Model\JournalEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class TransactionController extends Controller
{
    public function index($company_id){
        $transactions = CompanyTransaction::where('from','=',$company_id)
            ->orWhere('to','=',$company_id)->get();
        return view('admin.transaction.index')->with([
            'transactions'  => $transactions
        ]);
    }

    public function create($company_id){
        $user_id = Auth::user()->id;
        $accounts = Account::where('company_id','=',$company_id)->get();
        $companies = Company::whereHas('users',function($query) use($user_id){
            $query->where('user_id','=',$user_id);
        })->get();
        return view('admin.transaction.create')->with([
            'accounts'  => $accounts,
            'companies' => $companies
        ]);
    }

    public function store(Request $request,$company_id){
        $journal_entry = JournalEntry::create([
            'narration' => $request->narration,
            'journal_date'  => Carbon::parse($request->journal_date)->format('Y-m-d'),
            'status'    => 0,
        ]);
        $debit_entry = Journal::create([
            'debit'             => $request->debit,
            'journal_date'      => $journal_entry->journal_date,
            'account_id'        => $request->debit_account_id,
            'journal_entry_id'  => $journal_entry->id
        ]);

        $credit_entry = Journal::create([
            'credit'            => $request->credit,
            'journal_date'      => $journal_entry->journal_date,
            'account_id'        => $request->credit_account_id,
            'journal_entry_id'  => $journal_entry->id,
            'journal_id'        => $debit_entry->id,
            'account_type'      => 1
        ]);

        $debit_entry->fill([
            'journal_id'    => $credit_entry->id
        ])->save();

        CompanyTransaction::create([
            'from'  => $company_id,
            'to'    => $request->company_id,
            'journal_entry_id_from' => $journal_entry->id,
            'amount'    => $request->amount
        ]);

        return redirect()->route('transactions',['company_id' => $request->route('company_id')]);
    }

    public function approve($company_id,$id){
        $accounts = Account::where('company_id','=',$company_id)->get();
        $transaction = CompanyTransaction::where([
            ['to','=',$company_id],
            ['id','=',$id],
            ['status','=',0],
        ])->firstOrFail();
        return view('admin.transaction.confirm')->with([
            'transaction'   => $transaction,
            'accounts'      => $accounts
        ]);
    }

    public function confirmApproval(Request $request,$company_id,$id){
        $transaction = CompanyTransaction::where([
            'to'    => $company_id,
            'id'    => $id
        ])->firstOrFail();

        $journal_entry = JournalEntry::create([
            'narration' => $request->narration,
            'journal_date'  => $request->journal_date,
        ]);
        $debit_entry = Journal::create([
            'debit'             => $request->debit,
            'journal_date'      => $journal_entry->journal_date,
            'account_id'        => $request->debit_account_id,
            'journal_entry_id'  => $journal_entry->id
        ]);

        $credit_entry = Journal::create([
            'credit'            => $request->credit,
            'journal_date'      => $journal_entry->journal_date,
            'account_id'        => $request->credit_account_id,
            'journal_entry_id'  => $journal_entry->id,
            'journal_id'        => $debit_entry->id,
            'account_type'      => 1
        ]);

        $debit_entry->fill([
            'journal_id'    => $credit_entry->id
        ])->save();

        $transaction->update([
            'status'    => 1,
            'journal_entry_id_to' => $journal_entry->id,
        ]);
        JournalEntry::findOrFail($transaction->journal_entry_id_from)->update([
            'status'    => 1
        ]);

        return redirect()->route('transactions',['company_id' => $request->route('company_id')]);
    }

}
