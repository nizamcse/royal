<?php

namespace App\Http\Controllers;

use App\Model\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(){
        $designations = Designation::orderBy('name','asc')->get();
        return view('admin.designation.index')->with([
            'designations'   => $designations
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        Designation::create($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        Designation::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        Designation::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
