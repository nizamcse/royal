<?php

namespace App\Http\Controllers;

use App\Model\Designation;
use App\Model\Employee;
use App\Model\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index($company_id){
        $employees = Employee::where('company_id','=',$company_id)->orderBy('id','desc')->get();
        return view('admin.employee.index')->with([
            'employees' => $employees,
        ]);
    }

    public function create($company_id){
        $designations = Designation::where('company_id','=',$company_id)->get();
        return view('admin.employee.create')->with([
            'designations'  => $designations
        ]);
    }

    public function store(Request $request){

        $this->validate($request,[
            'name'  => 'required|string',
            'contact_no'    => 'required',
        ]);

        $employee_data = $request->all();

        $in_time = Carbon::parse($request->in_time ?? 0);
        $exit_time = Carbon::parse($request->exit_time ?? 0);
        $hours = $in_time->copy()->diffInHours($exit_time);
        $minutes = $in_time->copy()->addHours($hours)->diffInMinutes($exit_time);
        $working_hour = $hours + ($minutes / 100);
        $employee_data['minimum_working_hour'] = $working_hour;
        $employee = Employee::create($employee_data);


        $data = [];


        if($request->file('photo')){
            $name = time().".".$request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('public/attachments',$name);
            $name = 'public/attachments/'.$name;
            $data['photo'] = $name;

        }

        if(count($data)){
            $employee->fill($data)->save();
        }

        return redirect()->route('employees',['company_id' => $request->route('company_id')])->withMessage([
            'status'    => true,
            'message'   => 'Record has been created successfully.'
        ]);
    }

    public function employee($company_id,$id){
        $employee = Employee::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->first();
        $leave_types = LeaveType::where('company_id',$company_id)->get();
        return view('admin.employee.show')->with([
            'employee' => $employee,
            'leave_types'   => $leave_types
        ]);

    }

    public function edit($company_id,$id){
        $employee = Employee::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->first();
        $designations = Designation::where('company_id',$company_id)->get();
        return view('admin.employee.edit')->with([
            'employee' => $employee,
            'designations'  => $designations
        ]);
    }

    public function update(Request $request,$company_id,$id){
        $dm = Employee::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->first();
        $dmu = $dm->user;
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|min:11',
        ]);

        Employee::findOrFail($id)->update($request->all());

        $data = [];

        if($request->file('photo')){
            $name = time().".".$request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('public/attachments',$name);
            $name = 'public/attachments/'.$name;
            $data['photo'] = $name;

        }

        if(count($data)){
            Employee::findOrFail($id)->update($data);
        }

        return redirect()->route('employees')->withMessage([
            'status'    => true,
            'message'   => 'Record has been updated successfully.'
        ]);
    }

    public function delete($company_id,$id){
        Employee::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => false,
            'message'   => 'Record has been deleted successfully.'
        ]);
    }
}
