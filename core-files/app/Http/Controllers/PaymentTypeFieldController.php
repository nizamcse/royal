<?php

namespace App\Http\Controllers;

use App\Model\PaymentTypeField;
use Illuminate\Http\Request;

class PaymentTypeFieldController extends Controller
{
    public function store(Request $request,$company_id,$id){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        PaymentTypeField::create([
            'name'  => $request->name,
            'payment_type_id'   => $id,
            'date_type' => $request->date_type ? 1 : 0
        ]);
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        PaymentTypeField::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update([
            'name'  => $request->name,
            'date_type' => $request->date_type ? 1 : 0
        ]);
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        PaymentTypeField::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
