<?php

namespace App\Http\Controllers;

use App\Model\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::orderBy('name','asc')->get();
        return view('admin.permission.index')->with([
            'permissions'   => $permissions
        ]);
    }
}
