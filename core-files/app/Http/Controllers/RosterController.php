<?php

namespace App\Http\Controllers;

use App\Model\Roster;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function store(Request $request){
        Roster::create($request->all());
        return redirect()->back();
    }

    public function delete($id){
        Roster::findOrFail($id)->delete();
        return redirect()->back();
    }
}
