<?php

namespace App\Http\Controllers;

use App\Model\Expense;
use App\Model\ExpenseHead;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(){
        $expenses = Expense::orderBy('id','desc')->get();
        $expense_heads = ExpenseHead::orderBy('name','asc')->get();
        return view('admin.expense.index')->with([
            'expenses' => $expenses,
            'expense_heads'   => $expense_heads
        ]);
    }


    public function store(Request $request){
        $this->validate($request,[
            'expense_head_id'  =>  'required',
            'amount'            => 'required'
        ]);

        Expense::create($request->all());

        return redirect()->back()->withMessage([
            'status'    => true,
            'message'   => 'Record has been created successfully.'
        ]);

    }


    public function expense($company_id,$id){
        $expense = Expense::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->first();
        return response()->json($expense,200);
    }

    public function update(Request $request,$company_id,$id){
        $this->validate($request,[
            'expense_head_id'  =>  'required',
            'amount'            => 'required'
        ]);
        Expense::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->except('_token'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'message'   => 'Record has been updated successfully.'
        ]);
    }

    public function delete($company_id,$id){
        Expense::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => false,
            'message'   => 'Record has been deleted successfully.'
        ]);
    }
}
