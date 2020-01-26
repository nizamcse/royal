<?php

namespace App\Http\Controllers;

use App\Model\Vacation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VacationController extends Controller
{
    protected $year;
    public function __construct(Request $request)
    {
        $this->year = $request->year ?? Carbon::today()->year;

    }

    public function index($company_id){
        $vacations = Vacation::whereYear('from_date',$this->year)->where('company_id','=',$company_id)->get();
        return view('admin.vacation.index')->with([
            'vacations' => $vacations,
            'year'  => $this->year
        ]);
    }

    public function create($company_id){
        return view('admin.vacation.create');
    }

    public function store(Request $request,$company_id){
        Vacation::create($request->all());
        return redirect()->route('vacations',['company_id' => $company_id])->withMessage([
            'status'    => true,
            'message'   => 'Record has been created successfully.'
        ]);
    }

    public function edit($company_id,$id){
        $vacations = Vacation::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->firstOrFail();
        return view('admin.vacation.edit')->withVacation($vacations);
    }

    public function update(Request $request,$company_id,$id){
        $vacations = Vacation::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->firstOrFail();
        $vacations->update($request->all());
        return redirect()->route('vacations',['company_id' => $company_id])->withMessage([
            'status'    => true,
            'message'   => 'Record has been updated successfully.'
        ]);
    }

    public function delete($company_id,$id){
        Vacation::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->route('vacations',['company_id' => $company_id])->withMessage([
            'status'    => true,
            'message'   => 'Record has been created successfully.'
        ]);
    }
}
