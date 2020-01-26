<?php

namespace App\Http\Controllers;

use App\Model\Attendance;
use App\Model\Company;
use App\Model\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class AttendanceController extends Controller
{
    public function index($company_id,$date = null){
        //return Attendance::whereMonth('attendance_date','>',1)->paginate(10);
        if(!empty($date)){
            $attendance_date = Carbon::parse($date)->format('Y-m-d');
            $attendances = Attendance::where('attendance_date','=',$attendance_date)
                ->where('company_id','=',$company_id)->get();
        }else{
            $attendances = Attendance::where('attendance_date','=',Carbon::today()->format('Y-m-d'))
                ->where('company_id','=',$company_id)->get();
        }
        return view('admin.attendance.index')->with([
            'attendances'   => $attendances,
            'date'          => $date,
        ]);
    }

    public function getAttendanceReport(Request $request,$company_id){
        //return $request->all();

        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        if($request->employee_id){
            $employee_id = $request->employee_id;
            return Attendance::with(['employee'])->whereHas('employee',function($query) use($employee_id){
                $query->where('id','=',$employee_id);
            })->whereBetween('attendance_date',[$from_date,$to_date])->paginate($request->paginate ?? 10);
        }

        return  Attendance::with(['employee'])->whereBetween('attendance_date',[$from_date,$to_date])->paginate($request->paginate ?? 10);

    }
    public function downloadAttendanceReport (Request $request,$company_id){

        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        $attendances = [];
        $employee = null;
        if($request->employee_id){
            $employee_id = $request->employee_id;
            $employee = Employee::find($request->employee_id);
            $attendances = Attendance::with(['employee'])->whereHas('employee',function($query) use($employee_id){
                $query->where('id','=',$employee_id);
            })->whereBetween('attendance_date',[$from_date,$to_date])->get();
        }

        $attendances = Attendance::with(['employee'])->whereBetween('attendance_date',[$from_date,$to_date])->paginate($request->paginate ?? 10);
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.attendance-report', [
            'company'         => $company,
            'attendances'     => $attendances,
            'employee'        => $employee,
            'from_date'       => $from_date,
            'to_date'         => $to_date
        ]);
        return $pdf->stream();
    }

    public function create($company_id){
        $employees = Employee::where('company_id','=',$company_id)->get();
        return view('admin.attendance.create')->with([
            'employees' => $employees
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'attendance_date'   => ['required']
        ]);
        $date = Carbon::parse($request->attendance_date)->format('Y-m-d');
        foreach ($request->input('attendance') as $attendance){
            if($attendance['in_time'] && $attendance['exit_time']){
                $data = $attendance;
                $data['attendance_date'] = $date;
                Attendance::create($data);
            }
        }
        return redirect()->route('attendances',['company_id' => $request->route('company_id'),'date' => $date]);
    }
}
