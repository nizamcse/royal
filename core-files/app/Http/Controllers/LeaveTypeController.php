<?php

namespace App\Http\Controllers;

use App\Model\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index($company_id){
        $leave_types = LeaveType::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.leave-type.index')->with([
            'leave_types'   => $leave_types
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        LeaveType::create($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        LeaveType::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        LeaveType::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
