<?php

namespace App\Http\Controllers;

use App\Model\RawMaterial;
use App\Model\Unit;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index($company_id){
        $raw_materials = RawMaterial::with(['unit'])->where('company_id','=',$company_id)->orderBy('name','asc')->get();
        $units = Unit::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.raw-material.index')->with([
            'raw_materials'   => $raw_materials,
            'units'   => $units
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
            'unit_id' => 'required'
        ]);
        RawMaterial::create($request->only('name','unit_id'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        RawMaterial::where([
            ['id','=',$id],
            ['company_id','=',$company_id],
        ])->update($request->only('name','unit_id'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        RawMaterial::where([
            ['id','=',$id],
            ['company_id','=',$company_id],
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
