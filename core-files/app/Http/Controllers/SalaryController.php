<?php

namespace App\Http\Controllers;

use App\Model\Attendance;
use App\Model\Bonus;
use App\Model\DeductionType;
use App\Model\Employee;
use App\Model\MonthlyLeave;
use App\Model\MonthlyVacation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class SalaryController extends Controller
{

    public function index($company_id){
        $employee = Employee::where('company_id','=',$company_id)->get();
        return view('admin.salary.index')->with([
            'employees' => $employee
        ]);
    }

    public function create($company_id){
        $employee = Employee::where('company_id','=',$company_id)->get();
        $bonuses = Bonus::where('company_id','=',$company_id)->get();
        $deductions = DeductionType::where('company_id','=',$company_id)->get();
        return view('admin.salary.create')->with([
            'employees' => $employee,
            'deductions'    => $deductions,
            'bonuses'   => $bonuses
        ]);
    }

    public function store(Request $request,$conpany_id){

    }

    public function getSalaryDetails(Request $request,$company_id){

        $start = Carbon::createFromDate($request->year,$request->month)->startOfMonth();
        $end = Carbon::createFromDate($request->year,$request->month)->endOfMonth();
        $employee = Employee::where([
            'company_id'    => $company_id,
            'id'            => $request->employee_id
        ])->first();

        $employee_id = $employee->id;
        // Vacation of requested month
        $monthly_vacation =  MonthlyVacation::where([
            ['month','=',$start->month],
            ['year','=',$start->year],
        ])->get();

        // Attendance

        $attendance = Attendance::where([
            'employee_id'   => $employee->id
        ])->whereBetween('attendance_date',[$start->format('Y-m-d'),$end->format('Y-m-d')])->get();

        // Late Attendance

        $late_attendance = Attendance::where([
            'employee_id'   => $employee->id
        ])->whereBetween('attendance_date',[$start->format('Y-m-d'),$end->format('Y-m-d')])
        ->where('in_time','>',$employee->in_time);

        // Total Working Hour
        $total_working_hour = $attendance->sum('measurement_quantity');

        $period = CarbonPeriod::create($start,$end);
        $days = [];
        foreach ($period as $date) {
            $days[] = $date->format('w');
        }
        $days_without_weekend = array_diff($days,$employee->weekends);

        $total_weekends = count($days) - count($days_without_weekend);

        // Counting Leaves

        $total_leaves = MonthlyLeave::whereHas('leave',function($query) use ($employee_id){
            $query->where('employee_id','=',$employee_id);
        })->where([
            'month' => $start->month,
            'year'  => $start->year
        ])->sum('days');

        $days_without_vacation_leave_and_weekends = count($days_without_weekend) - $monthly_vacation->sum('days') - $total_leaves;



        $minimum_working_hour = $employee->minimum_working_hour * $days_without_vacation_leave_and_weekends;

        if($employee->salary_type == 1){
            $overtime = $total_working_hour - $minimum_working_hour;
            if($overtime >0){
                $overtime_salary = $overtime * $employee->salary;
                $basic_salary = $minimum_working_hour * $employee->salary;
            }else{
                $overtime_salary =0;
                $basic_salary = $employee->salary * $total_working_hour;
            }
        }else{
            $overtime = 0;
            $overtime_salary =0;
            $basic_salary = $employee->salary;
        }

        return response()->json([
            'totalDays'         => count($days),
            'lately_attend'     => $late_attendance->count(),
            'total_attend'      => $attendance->count(),
            'should_attend'     => $days_without_vacation_leave_and_weekends,
            'total_leaves'      => $total_leaves,
            'total_working_hour'=> $total_working_hour,
            'minimum_working_hour'=> $minimum_working_hour,
            'vacation'          => $monthly_vacation->sum('days'),
            'extra_working_hour'=> $overtime,
            'total_weekends'    => $total_weekends,
            'basic_salary'      => $basic_salary,
            'overtime_salary'   => $overtime_salary,
        ],200);
    }
}
