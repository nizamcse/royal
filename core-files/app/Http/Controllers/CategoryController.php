<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($company_id){
        $categories = Category::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.category.index')->with([
            'categories'   => $categories
        ]);
    }

    public function store(Request $request,$company_id){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        Category::create($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created category.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        Category::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated category.'
        ]);
    }
    public function delete($company_id,$id){
        Category::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted category.'
        ]);
    }
}
