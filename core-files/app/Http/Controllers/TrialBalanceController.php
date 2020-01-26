<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Company;
use Illuminate\Http\Request;
use PDF;

class TrialBalanceController extends Controller
{
    public function index($company_id){
        $accounts = Account::with(['journals'])->where('company_id','=',$company_id)->get();
        return view('admin.trial-balance.index')->with([
            'accounts'  => $accounts
        ]);
    }

    public function download($company_id){
        $accounts = Account::with(['journals'])->where('company_id','=',$company_id)->get();

        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.trial-balance', [
            'company'   => $company,
            'accounts'   => $accounts
        ]);
        return $pdf->stream();
    }
}
