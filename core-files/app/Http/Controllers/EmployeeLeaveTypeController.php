<?php

namespace App\Http\Controllers;

use App\Model\Employee;
use App\Model\EmployeeLeaveType;
use App\Model\LeaveType;
use Illuminate\Http\Request;

class EmployeeLeaveTypeController extends Controller
{
    public function store(Request $request){
        $employee = Employee::findOrFail($request->input('employee_id'));
        $leave_type = LeaveType::findOrFail($request->input('leave_type_id'));
        $employee_leave_type = EmployeeLeaveType::firstOrCreate([
            'employee_id'       => $employee->id,
            'leave_type_id'     => $leave_type->id,
        ]);
        $employee_leave_type->fill([
            'max_allowed_days'  => $request->input('max_allowed_days')
        ])->save();
        return redirect()->back();
    }

    public function leaveType($company_id,$id){
        $leave_type = EmployeeLeaveType::where([
            ['id','=',$id]
        ])->first();
        return response()->json($leave_type,200);
    }

    public function update(Request $request,$id){
        $employee = Employee::findOrFail($request->input('employee_id'));
        $leave_type = LeaveType::findOrFail($request->input('leave_type_id'));
        $employee_leave_type = EmployeeLeaveType::findOrFail($id);
        $employee_leave_type->update([
            'employee_id'       => $employee->id,
            'leave_type_id'     => $leave_type->id,
            'max_allowed_days'  => $request->input('max_allowed_days')
        ]);

        return redirect()->back();
    }
}
