<?php

namespace App\Http\Controllers;

use App\Category;
use App\Model\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{

    public function index($company_id){
        $grades = Grade::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        $categories = Category::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.grade.index')->with([
            'grades'   => $grades,
            'categories'    => $categories
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
            'min_radius'  => 'required|numeric',
            'max_radius'  => 'required|numeric',
        ]);
        Grade::create($request->only('name','min_radius','max_radius','price_per_unit','category_id'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        Grade::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name','min_radius','max_radius','price_per_unit','category_id'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        Grade::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
