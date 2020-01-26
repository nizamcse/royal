<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Employee;
use App\Model\Leave;
use App\Model\LeaveType;
use App\Model\MonthlyLeave;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use PDF;

class LeaveController extends Controller
{

    public function index($company_id){
        $leaves = Leave::with(['employee'])->where([
            'company_id'    => $company_id,
        ])->get();
        $employees = Employee::where([
            'company_id'    => $company_id,
        ])->get();
        return view('admin.leave.index')->with([
            'employees' => $employees,
            'leaves'    => $leaves,
        ]);
    }

    public function getLeaves(Request $request,$company_id){

        $leaves = null;

        if($request->month){
            $start = Carbon::createFromDate($request->year,$request->month)->startOfMonth();
            $end = Carbon::createFromDate($request->year,$request->month)->endOfMonth();
            if($request->employee_id){
                $employee_id = $request->employee_id;
                $leaves = Leave::with(['employee'])->whereHas('employee',function($query)use($employee_id){
                    $query->where('id','=',$employee_id);
                })->where('company_id','=',$company_id)
                    ->where( 'from_date','>=',$start)
                    ->where('to_date','<=',$end)->paginate(10);
            }else{
                $leaves = Leave::with(['employee'])->where('company_id','=',$company_id)
                    ->where( 'from_date','>=',$start)
                    ->where('to_date','<=',$end)->paginate(10);
            }
        } else{
            if($request->employee_id){
                $employee_id = $request->employee_id;
                $leaves = Leave::with(['employee'])->whereHas('employee',function($query)use($employee_id){
                    $query->where('id','=',$employee_id);
                })->where('company_id','=',$company_id)->whereYear('from_date','>=',$request->year)
                    ->whereYear('to_date','<=',$request->year)->paginate(10);
            }else{
                //return $request->all();
                $leaves = Leave::with(['employee'])->where('company_id','=',$company_id)->whereYear('from_date','>=',$request->year)
                    ->whereYear('to_date','<=',$request->year)->paginate(10);
            }
        }

        return $leaves;
    }

    public function downloadLeaves (Request $request,$company_id){

        $leaves = null;

        if($request->month){
            $start = Carbon::createFromDate($request->year,$request->month)->startOfMonth();
            $end = Carbon::createFromDate($request->year,$request->month)->endOfMonth();
            if($request->employee_id){
                $employee_id = $request->employee_id;
                $leaves = Leave::with(['employee'])->whereHas('employee',function($query)use($employee_id){
                    $query->where('id','=',$employee_id);
                })->where('company_id','=',$company_id)
                    ->where( 'from_date','>=',$start)
                    ->where('to_date','<=',$end)->get();
            }else{
                $leaves = Leave::with(['employee'])->where('company_id','=',$company_id)
                    ->where( 'from_date','>=',$start)
                    ->where('to_date','<=',$end)->get();
            }
        } else{
            if($request->employee_id){
                $employee_id = $request->employee_id;
                $leaves = Leave::with(['employee'])->whereHas('employee',function($query)use($employee_id){
                    $query->where('id','=',$employee_id);
                })->where('company_id','=',$company_id)->whereYear('from_date','>=',$request->year)
                    ->whereYear('to_date','<=',$request->year)->paginate(10);
            }else{
                //return $request->all();
                $leaves = Leave::with(['employee'])->where('company_id','=',$company_id)->whereYear('from_date','>=',$request->year)
                    ->whereYear('to_date','<=',$request->year)->get();
            }
        }

        $company = Company::findOrFail($company_id);
        $employee = Employee::find($request->employee_id);
        $pdf = PDF::loadView('pdf.leave-report', [
            'company'         => $company,
            'month'     => $request->month,
            'year'        => $request->year,
            'employee'  => $employee,
            'leaves'    => $leaves
        ]);
        return $pdf->stream();
    }

    public function create($company_id){
        $employees = Employee::with(['leaveTypes'])->where('company_id','=',$company_id)->get();
        $leave_types = LeaveType::where('company_id','=',$company_id)->get();
        return view('admin.leave.create')->with([
            'employees'     => $employees,
            'leave_types'   => $leave_types
        ]);
    }

    public function store(Request $request,$company_id){

        $leave = Leave::create([
            'employee_id'   => $request->input('employee_id'),
            'leave_type_id' => $request->input('leave_type_id'),
            'from_date'     => $request->input('from_date'),
            'to_date'       => $request->input('to_date'),
        ]);

        $from_date = Carbon::parse( $request->input('from_date'))->format('Y-m-d');
        $to_date = Carbon::parse( $request->input('to_date'))->format('Y-m-d');
        $period = CarbonPeriod::create($from_date, $to_date);
        $dates = collect($period)->groupBy(function($date){
            return $date->format('Y');
        })->map(function ($item){
            return $item->groupBy(function($d){
                return $d->format('m');
            })->map(function($item){
                return $item->count();
            });
        });

        foreach ($dates as $year => $months){
            foreach ($months as $month => $days){
                MonthlyLeave::create([
                    'leave_id'  => $leave->id,
                    'year'      => $year,
                    'month'     => $month,
                    'days'      => $days,
                ]);
            }
        }

        return redirect()->route('leaves',['company_id' => $company_id]);
    }

    public function edit($company_id,$id){
        $employees = Employee::with(['leaveTypes'])->where('company_id','=',$company_id)->get();
        $leave_types = LeaveType::where('company_id','=',$company_id)->get();
        $leave = Leave::with(['employee.leaveTypes'])->where([
            'id'    => $id
        ])->first();
        return view('admin.leave.edit')->with([
            'employees'     => $employees,
            'leave_types'   => $leave_types,
            'leave'         => $leave
        ]);
    }

    public function update(Request $request,$company_id,$id){
        $leave = Leave::where([
            'id'            => $id,
            'company_id'    => $company_id
        ])->first();

        $leave->update([
            'employee_id'   => $request->input('employee_id'),
            'leave_type_id' => $request->input('leave_type_id'),
            'from_date'     => $request->input('from_date'),
            'to_date'       => $request->input('to_date'),
        ]);

        $monthly_leaves = MonthlyLeave::where([
            'leave_id'  => $leave->id
        ])->get();
        foreach ($monthly_leaves as $monthly_leave){
            $monthly_leave->delete();
        }

        $from_date = Carbon::parse( $request->input('from_date'))->format('Y-m-d');
        $to_date = Carbon::parse( $request->input('to_date'))->format('Y-m-d');
        $period = CarbonPeriod::create($from_date, $to_date);
        $dates = collect($period)->groupBy(function($date){
            return $date->format('Y');
        })->map(function ($item){
            return $item->groupBy(function($d){
                return $d->format('m');
            })->map(function($item){
                return $item->count();
            });
        });

        foreach ($dates as $year => $months){
            foreach ($months as $month => $days){
                MonthlyLeave::create([
                    'leave_id'  => $leave->id,
                    'year'      => $year,
                    'month'     => $month,
                    'days'      => $days,
                ]);
            }
        }

        return redirect()->route('leaves',['company_id' => $company_id]);
    }


    public function delete($company_id,$id){
        $leave = Leave::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->first();
        $leave->delete();
        return redirect()->back();
    }
}
