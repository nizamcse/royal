<?php

namespace App\Http\Controllers;

use App\Model\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index($company_id){
        $payment_types = PaymentType::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.payment-type.index')->with([
            'payment_types'   => $payment_types
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        PaymentType::create($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        PaymentType::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        PaymentType::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
