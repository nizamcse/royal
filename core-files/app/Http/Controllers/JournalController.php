<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Company;
use App\Model\Journal;
use App\Model\JournalEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class JournalController extends Controller
{
    public function index($company_id){
        return view('admin.journal.index');
    }
    public function getJournals(Request $request,$company_id){
        $wheres[] = ['company_id','=',$company_id];
        if($request->date_from){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['journal_date','>=',$date_from];
        }
        if($request->date_to){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['journal_date','<=',$date_to];
        }

        if($request->narration){
            $wheres[] = ['narration','like','%'.$request->narration.'%'];
        }
        $journal_entries = JournalEntry::with(['debited.account','credited.account'])->where($wheres)->orderBy('journal_date','DESC')->paginate($request->itemPerPage ?? 10);

        $journals = [];

        foreach ($journal_entries as $journal_entry){
            $journal = [
                'id'    => $journal_entry->id,
                'journal_date'  => $journal_entry->journal_date,
                'narration' => $journal_entry->narration,
                'debit' => [
                    'account'   => $journal_entry->debit_row ? $journal_entry->debit_row->account ? $journal_entry->debit_row->account->name : '' : '',
                    'amount'    => $journal_entry->debit_row ? number_format($journal_entry->debit_row->debit,2) : ''
                ],
                'credit'    => [
                    'account'   => $journal_entry->credit_row ? $journal_entry->credit_row->account ? $journal_entry->credit_row->account->name : '' : '',
                    'amount'    => $journal_entry->credit_row ? number_format($journal_entry->credit_row->credit,2) : ''
                ]
            ];
            $journals[] = $journal;
        }

        return response()->json([
            'current_page'  => $journal_entries->currentPage(),
            'last_page'     => $journal_entries->lastPage(),
            'data'          => $journals
        ],200);
    }
    public function downloadJournals (Request $request,$company_id){
        $wheres[] = ['company_id','=',$company_id];
        if($request->date_from){
            $date_from = Carbon::parse($request->date_from)->format('Y-m-d');
            $wheres[] = ['journal_date','>=',$date_from];
        }
        if($request->date_to){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['journal_date','<=',$date_to];
        }

        if($request->narration){
            $wheres[] = ['narration','like','%'.$request->narration.'%'];
        }
        $journal_entries = JournalEntry::with(['debited.account','credited.account'])->where($wheres)->orderBy('journal_date','DESC')->get()->chunk(18);
        $company = Company::findOrFail($company_id);
//        return view('pdf.journal', [
//            'journal_entries'    => $journal_entries,
//            'company'       => $company
//        ]);

        $pdf = PDF::loadView('pdf.journal', [
            'journal_entries'    => $journal_entries,
            'company'       => $company
        ]);
        return $pdf->stream();


    }
    public function create($company_id){
        $accounts = Account::where([
            ['company_id','=',$company_id]
        ])->get();
        return view('admin.journal.create')->with([
            'accounts'  => $accounts
        ]);
    }

    public function show($company_id,$id){
        $journal_entry = JournalEntry::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->firstOrFail();
        return view('admin.journal.show')->with([
            'journal_entry' => $journal_entry
        ]);
    }

    public function store(Request $request){
        $journal_entry = JournalEntry::create($request->only('narration','journal_date'));
        $debit_entry = Journal::create([
            'debit'             => $request->debit,
            'journal_date'      => $request->journal_date,
            'account_id'        => $request->debit_account_id,
            'journal_entry_id'  => $journal_entry->id
        ]);

        $credit_entry = Journal::create([
            'credit'            => $request->credit,
            'journal_date'      => $request->journal_date,
            'account_id'        => $request->credit_account_id,
            'journal_entry_id'  => $journal_entry->id,
            'journal_id'        => $debit_entry->id,
            'account_type'      => 1
        ]);

        $debit_entry->fill([
            'journal_id'    => $credit_entry->id
        ])->save();

        return redirect()->route('show-journal',['company_id' => $request->route('company_id'),'id' => $journal_entry->id]);
    }

    public function edit($company_id,$id){
        $journal_entry = JournalEntry::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->firstOrFail();
        $accounts = Account::where([
            ['company_id','=',$company_id]
        ])->get();
        return view('admin.journal.edit')->with([
            'accounts'  => $accounts,
            'journal_entry' => $journal_entry
        ]);
    }


    public function update(Request $request,$company_id,$id){
        $journal_entry = JournalEntry::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->firstOrFail();

        $journal_entry->update($request->only('narration','journal_date'));

        $debit_entry = Journal::where([
            'journal_entry_id'    => $journal_entry->id,
            'id'            => $request->debit_id,
        ])->firstOrFail();

        $debit_entry->update([
            'debit'             => $request->debit,
            'journal_date'      => $request->journal_date,
            'account_id'        => $request->debit_account_id,
        ]);

        $credit_entry = Journal::where([
            'journal_entry_id'    => $journal_entry->id,
            'id'            => $request->credit_id,
        ])->firstOrFail();

        $credit_entry->update([
            'credit'            => $request->credit,
            'journal_date'      => $request->journal_date,
            'account_id'        => $request->credit_account_id,
        ]);

        return redirect()->route('show-journal',['company_id' => $request->route('company_id'),'id' => $journal_entry->id]);
    }

    public function delete($company_id,$id){
        JournalEntry::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->delete();
        return redirect()->route('journals',['company_id' => $company_id]);
    }

}
