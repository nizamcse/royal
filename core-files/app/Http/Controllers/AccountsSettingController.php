<?php

namespace App\Http\Controllers;

use App\Model\Company;
use Illuminate\Http\Request;

class AccountsSettingController extends Controller
{
    public function index($company_id){
        $company = Company::findOrFail($company_id);
        return view('admin.accounts-setting.index')->with([
            'start_month'   => $company->start_month,
            'end_month'     => $company->end_month,
        ]);
    }


    public function update(Request $request,$company_id){
        $start = (int)$request->start_month;
        $end = (int)$request->end_month;

        $difference = $start - $end;

        if($difference == 11 || $difference == 1 || $difference == -11){
            Company::where('id','=',$company_id)->update([
                'start_month'   => $start,
                'end_month'     => $end,
            ]);
        }else{
            return redirect()->back()->withMessage([
                'status'    => false,
                'text'      => "Please select valid month." . $difference
            ]);
        }
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => "Successfully updated the accounts settings."
        ]);
    }
}
