<?php

namespace App\Http\Controllers;

use App\Model\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index($company_id){
        $accounts = Account::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.account.index')->with([
            'accounts'   => $accounts
        ]);
    }

    public function store(Request $request,$company_id){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        Account::firstOrCreate([
            'name'  => $request->name,
            'slug'  => $request->name,
            'type'  => $request->type,
            'company_id'    => $company_id
        ]);
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        Account::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update([
            'name'  => $request->name,
            'slug'  => $request->name,
            'type'  => $request->type
        ]);
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        Account::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
