<?php

namespace App\Http\Controllers;

use App\Model\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index($company_id){
        $bonuses = Bonus::where('company_id','=',$company_id)->orderBy('name','asc')->get();
        return view('admin.bonus.index')->with([
            'bonuses'   => $bonuses
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'  => 'required',
        ]);
        Bonus::create($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully created region.'
        ]);
    }

    public function update(Request $request,$company_id,$id){
        Bonus::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully updated region.'
        ]);
    }
    public function delete($company_id,$id){
        Bonus::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withMessage([
            'status'    => true,
            'text'      => 'Successfully deleted region.'
        ]);
    }
}
