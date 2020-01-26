<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Summary;
use App\Model\SummaryType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class SummaryController extends Controller
{
    public function index(Request $request){
        $summary_types = SummaryType::company()->orderBy('name', 'asc')->get();
        $summariesQuery = Summary::company();

        if($request->from_date){
            $carbon_from_date = Carbon::createFromFormat('d-m-Y', $request->from_date);
            $from_date = $carbon_from_date->format('Y-m-d');
            $summariesQuery->where('summary_data','>=',$from_date);
        }

        if($request->end_date){
            $carbon_end_date = Carbon::createFromFormat('d-m-Y', $request->end_date);
            $end_date = $carbon_end_date->format('Y-m-d');
            $summariesQuery->where('summary_data','<=',$end_date);
        }


        if($request->summary_type){
            $summariesQuery->where('summary_type_id',$request->summary_type);
        }

        $summaries = $summariesQuery->orderBy('id', 'DESC')->paginate(10);
        return view('admin.summary.index')->with([
            'summary_types' => $summary_types,
            'summaries' => $summaries,
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'summary_type_id' => 'required',
            'summary_data' => 'required',
            'type' => 'required',
        ]);
        $carbon = Carbon::createFromFormat('d-m-Y',$request->summary_data);

        $lastRecord = Summary::company()->first();
        $balance = $lastRecord->balance??0;
//        return $request;
        $summary = new Summary();
        $summary->summary_type_id = $request->summary_type_id;
        $summary->comment = $request->comment;
        $summary->company_id = $request->company_id;
        $summary->summary_data = $carbon->format('Y-m-d');

        if($request->type === 'receive'){
            $summary->balance = $balance + $request->amount;
            $summary->receive = $request->amount;
        }else{
            $summary->balance = $balance - $request->amount;
            $summary->payment = $request->amount;
        }

        $summary->save();

        return redirect()->back()->with([
            'status'    => true,
            'message'   => 'Record has been created successfully.',
            'alert'     => 'success'
        ]);
    }

    public function downloads(Request $request,$company_id){
//        dd($request->end_date);
        $wheres[] = ['company_id','=',$company_id];
        $filter_type = SummaryType::where('id', $request->summary_type)->first();

        $date_form =  $request->from_date;
        $to_date = $request->end_date;

        if($request->from_date){
            $date_from = Carbon::parse($request->from_date)->format('Y-m-d');
            $wheres[] = ['summary_data','>=',$date_from];
        }
        if($request->date_to){
            $date_to = Carbon::parse($request->date_to)->format('Y-m-d');
            $wheres[] = ['summary_data','<=',$date_to];
        }

        if($request->summary_type){
            $wheres[] = ['summary_type_id',$request->summary_type];
        }
        $summaries = Summary::where($wheres)->orderBy('id','DESC')->paginate(10);
        $company = Company::findOrFail($company_id);
        $pdf = PDF::loadView('pdf.summaries', [
            'summaries'   => $summaries,
            'company'     => $company,
            'filter_type' => $filter_type,
            'date_form'   => $date_form,
            'to_date'    => $to_date
        ]);
        return $pdf->stream();

//
//        return view('pdf.summaries')->with([
//            'summaries'   => $summaries,
//            'company'     => $company,
//            'filter_type' => $filter_type,
//            'date_form'   => $date_form,
//            'to_date'    => $to_date
//        ]);
    }
}
