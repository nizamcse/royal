<?php

namespace App\Http\Controllers;

use App\Model\Permission;
use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index($company_id){
        $roles = Role::where('company_id','=',$company_id)->get();
        return view('admin.role.index')->with([
            'roles' => $roles
        ]);
    }

    public function create($company_id){
        $permissions = Permission::all();
        return view('admin.role.create')->with([
            'permissions' => $permissions
        ]);
    }

    public function show($company_id,$id){
        $role = Role::with('permissions')->where('company_id','=',$company_id)->where('id','=',$id)->first();
        return view('admin.role.show')->with([
            'role'  => $role
        ]);
    }

    public function store(Request $request,$company_id){
        //return $request->all();
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = Role::firstOrCreate([
            'name' => $request->name,
            'company_id'    => $company_id
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles',['company_id' => $request->route('company_id')]);
    }

    public function edit($company_id,$id){
        $role = Role::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
        ])->firstOrFail();

        $permissions = Permission::whereDoesntHave('roles',function($query) use($role){
            $query->where('role_id','=',$role->id);
        })->get();

        $selected_permissions = Permission::whereHas('roles',function($query) use($role){
            $query->where('role_id','=',$role->id);
        })->get();

        return view('admin.role.edit')->with([
            'permissions'   => $permissions,
            'role'          => $role,
            'selected_permissions'  => $selected_permissions
        ]);
    }

    public function update(Request $request,$company_id,$id){
        $role = Role::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
        ])->firstOrFail();
         $role->update([
             'name' => $request->name,
         ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles',['company_id' => $request->route('company_id')]);
    }


    public function delete($company_id,$id){
        Role::where([
            ['company_id','=',$company_id],
            ['id','=',$id],
        ])->delete();

        return redirect()->route('roles',['company_id' => $company_id]);
    }
}
