<?php

namespace App\Http\Controllers;

use App\Model\AccountClosing;
use App\Model\AccountStatement;
use App\Model\Company;
use App\Model\Journal;
use App\Model\JournalEntry;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Config;

class AccountClosingController extends Controller
{
    public function index($company_id){
        $account_losings = AccountClosing::where('company_id','=',$company_id)->get();
        return view('admin.account-closing.index')->with([
            'account_closings'  => $account_losings
        ]);
    }

    public function create($company_id){
        $company = Company::where('id','=',$company_id)->firstOrFail();
        $month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $start_month = $month[$company->start_month-1];
        $end_month = $month[$company->end_month-1];
        return view('admin.account-closing.create')->with([
            'start' => $start_month,
            'end'   => $end_month
        ]);
    }

    public function check($company_id,$year){
        $company = Company::where('id','=',$company_id)->firstOrFail();
        if($company->start_month == 1){
            $closing_for = $year;
        }else{
            $closing_for = ($year -1) .'-'.$year;
        }
        if(!$this->validateClosing($company_id,$year)){
            return response()->json([
                'status'    => 0,
                'message'   => 'Failed! Please close the previous years accounts. It seems that your year end closing for the earlier years are not closed.'
            ],200);
        }
        return response()->json([
            'status'    => 1,
            'message'   => 'You can create your account closing for the year of '.$closing_for.' Confirm to close your accounts closing for '.$closing_for
        ],200);

    }

    public function store($company_id,$year){
        if(!$this->validateClosing($company_id,$year)){
            return response()->json([
                'status'    => 0,
                'message'   => 'Failed! Please close the previous years accounts. It seems that your year end closing for the earlier years are not closed.'
            ],200);
        }
        $company = Company::where('id','=',$company_id)->firstOrFail();
        $prev_closing_year = $year - 1;
        $prev_closing_month = $company->end_month;
        $closing_start_year = $year - 1;
        if($company->start_month == 1){
            $closing_starting_date = Carbon::createFromDate($year,$company->start_month)->startOfMonth();
            $closing_ending_date = Carbon::createFromDate($year,$company->end_month)->endOfMonth();
        }else{
            $closing_start_year = $year - 1;
            $closing_starting_date = Carbon::createFromDate($year-1,$company->start_month)->startOfMonth();
            $closing_ending_date = Carbon::createFromDate($year,$company->end_month)->endOfMonth();
        }
        $statements = $this->calculateAccountStatements($company_id,$closing_starting_date,$closing_ending_date);

        $prev_account_closing = AccountClosing::with(['accountStatements'])->where([
            ['company_id','=',$company_id],
            ['closing_end_year','=',$prev_closing_year],
            ['closing_ends_at','=',$prev_closing_month],
        ])->first();
        $account_closing = AccountClosing::create([
            'closing_start_year'    => $closing_start_year,
            'closing_end_year'      => $year,
            'closing_start_from'    => $closing_starting_date,
            'closing_ends_at'       => $closing_ending_date,
            'created_by'            => Auth::user()->id,
        ]);
        $prev_statements = [];
        foreach ($prev_account_closing->accountStatements as $accountStatement){
            $prev_statements[$accountStatement->account_type] = $accountStatement->balance;
        }
        foreach ($statements as $k => $s){
            $balance = $s + ($prev_statements[$k] ?? 0);
            AccountStatement::create([
                'account_closing_id'    => $account_closing->id
            ]);
            $statements[$k] = $balance;
        }
    }

    private function validateClosing($company_id,$year){
        $company = Company::where('id','=',$company_id)->firstOrFail();
        $prev_closing_year = $year;
        $prev_closing_month = $company->end_month;
        $closing_for = $year;
        if($company->start_month == 1){
            $prev_closing_year = $year -1;
        }else{
            $closing_for = ($year -1) .'-'.$year;
        }
        $account_closing = AccountClosing::where([
            ['company_id','=',$company_id],
            ['closing_end_year','=',$prev_closing_year],
            ['closing_ends_at','=',$prev_closing_month],
        ])->first();
        if(!$account_closing){
            $date = Carbon::createFromDate($prev_closing_year,$prev_closing_month)->endOfMonth();
            $previous_journals = JournalEntry::where([
                ['company_id','=',$company_id],
                ['journal_date','<=',$date],
            ])->take(1)->get();
            if(count($previous_journals)){
                return false;
            }
        }
        return true;
    }

    private function calculateAccountStatements($company_id,$start_date,$end_date){
        $account_types = Config::get('enums.account_types');
        try{
            $statements = [];
            foreach ($account_types as $ak => $account_type){
                $account_type = $ak;
                $from_date = $start_date;
                $to_date   = $end_date;
                $journals = Journal::where('company_id','=',$company_id)
                    ->whereHas('account',function($query) use($account_type){
                        $query->where('type','=',$account_type);
                    })->whereBetween('journal_date',[$from_date,$to_date])->get();

                // Initializing Balance
                $balance = 0;

                foreach($journals as $k => $journal){
                    if($journal->account_type){
                        $balance -= $journal->credit;
                    }else{
                        $balance += $journal->debit;
                    }
                }
                $statements[$ak] = $balance;
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }

        return $statements;
    }
}
