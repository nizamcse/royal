<?php

namespace App\Http\Controllers;

use App\Model\SummaryType;
use Illuminate\Http\Request;

class SummaryTypeController extends Controller
{
    public function index(){

        $summary_types = SummaryType::company()->orderBy('name', 'asc')->get();
        return view('admin.summary-type.index')->with([
            'summary_types' => $summary_types,
        ]);

    }
    public function getJsonSummaryType($company_id, $id){
        $summery_type = SummaryType::where([
            'company_id'    => $company_id,
            'id'            => $id,
        ])->first();
        return response()->json($summery_type, 200);
    }
    public function store(Request $request){

        $this->validate($request,[
            'name' => 'required'
        ]);

        $findExesting = SummaryType::company()->where('name', $request->name)->first();
        if($findExesting){
            return redirect()->back()->with([
                'message'      => 'Already existing in database.',
                'alert'     => 'error'
            ]);
        }else {
            SummaryType::create($request->all());
            return redirect()->back()->with([
                'status'    => true,
                'message'      => 'Successfully created summary type.',
                'alert'     => 'success'
            ]);
        }


    }

    public function update(Request $request, $company_id, $id){

        SummaryType::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name'));
        return redirect()->back()->with([
            'status'    => true,
            'text'      => 'Successfully updated region.',
            'alert'     => 'success'
        ]);
    }

    public function destroy($company_id, $id){
        SummaryType::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->with([
            'status'    => true,
            'text'      => 'Successfully delete region.',
            'alert'     => 'success'
        ]);
    }

}
