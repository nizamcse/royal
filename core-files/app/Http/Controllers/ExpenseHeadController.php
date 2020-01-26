<?php

namespace App\Http\Controllers;

use App\Model\ExpenseHead;
use Illuminate\Http\Request;

class ExpenseHeadController extends Controller
{
    public function index(){
        $expense_heads = ExpenseHead::orderBy('name','asc')->get();
        return view('admin.expense-head.index')->with([
            'expense_heads'   => $expense_heads
        ]);
    }

    public function store(Request $request){

        $this->validate($request,[
            'name'  => 'required',
        ]);
        ExpenseHead::firstOrCreate($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        ExpenseHead::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        ExpenseHead::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
