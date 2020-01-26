<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Employee;
use App\Model\EmployeeSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class EmployeeSalaryController extends Controller
{
    public function index($company_id){
        $employees = Employee::where('company_id','=',$company_id)->get();
        return view('admin.employee-salary.index')->with([
            'employees' => $employees
        ]);
    }
    public function getSalaries(Request $request,$company_id){
        $wheres = [
            ['company_id','=',$company_id]
        ];

        if($request->month){
            $wheres[] = ['month','=',$request->month];
        }

        if($request->year){
            $wheres[] = ['year','=',$request->year];
        }

        if($request->employee_id){
            $wheres[] = ['employee_id','=',$request->employee_id];
        }
        $employee_salaries = EmployeeSalary::with(['employee'])->where($wheres)->paginate(10);
        return response()->json($employee_salaries,200);
    }

    public function downloadSalaries (Request $request,$company_id){
        $wheres = [
            ['company_id','=',$company_id]
        ];

        if($request->month){
            $wheres[] = ['month','=',$request->month];
        }

        if($request->year){
            $wheres[] = ['year','=',$request->year];
        }

        if($request->employee_id){
            $wheres[] = ['employee_id','=',$request->employee_id];
        }
        $employee_salaries = EmployeeSalary::with(['employee'])->where($wheres)->paginate(10);
        $company = Company::findOrFail($company_id);
        return view('pdf.salary-sheet', [
            'employee_salaries'     => $employee_salaries,
            'company'               => $company,
            'month'                 => $request->month,
            'year'                  => $request->year
        ]);

        $pdf = PDF::loadView('pdf.salary-sheet', [
            'employee_salaries'     => $employee_salaries,
            'company'               => $company,
            'month'                 => $request->month,
            'year'                  => $request->year
        ])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
    public function store(Request $request,$company_id){
        $date = Carbon::createFromDate($request->year,$request->month);
        $employee = Employee::where([
            ['company_id','=',$company_id],
            ['id','=',$request->employee_id],
        ])->firstOrFail();

        $deductions = collect($request->deductions);
        $bonuses = collect($request->bonuses);

        $net_salary = $employee->salary + $bonuses->sum('amount') - $deductions->sum('amount');


        $employee_salary = EmployeeSalary::create([
            'company_id'            => $company_id,
            'employee_id'           => $employee->id,
            'basic_salary'          => $employee->salary,
            'bonuses_amount'        => $deductions->count() ? $deductions->sum('amount') : 0,
            'deductions_amount'     => $bonuses->count() ? $bonuses->sum('amount') : 0,
            'net_salary'            => $net_salary,
            'month'                 => $date->month,
            'year'                  => $date->year
        ]);

        return redirect()->route('employee-salary',['company_id' => $company_id,'id' => $employee_salary->id]);
    }

    public function show($company_id,$id){
        $employee_salary = EmployeeSalary::with(['employee'])->where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->firstOrFail();
        return view('admin.employee-salary.show')->with([
            'employee_salary'   => $employee_salary
        ]);
    }
}
