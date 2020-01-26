<?php

namespace App\Http\Controllers;

use App\Model\Good;
use App\Model\Unit;
use Illuminate\Http\Request;

class GoodController extends Controller
{
    public function index($company_id){
        $goods = Good::where([
            'company_id'    => $company_id
        ])->orderBy('name','asc')->get();
        $units = Unit::where([
            'company_id'    => $company_id
        ])->get();
        return view('admin.good.index')->with([
            'goods'   => $goods,
            'units'   => $units
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
            'unit_id' => 'required'
        ]);
        Good::create($request->only('name','price','unit_id','thickness','size'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        $this->validate($request,[
            'name'  => 'required',
            'unit_id' => 'required'
        ]);
        Good::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name','price','unit_id','thickness','size'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        Good::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
