<?php

namespace App\Http\Controllers;

use App\Model\Unit;
use Illuminate\Http\Request;


class UnitController extends Controller
{
    public function index($company_id){
        $units = Unit::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.unit.index')->with([
            'units'   => $units
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required'
        ]);
        Unit::create($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created unit.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        $unit = Unit::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->first();
        $unit->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated unit.'
        ]);
    }
    public function delete($company_id,$id){
        Unit::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted unit.'
        ]);
    }
}
