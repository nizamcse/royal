<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($company_id){
        $users = User::whereHas('companies',function($query) use($company_id){
            $query->where('company_id','=',$company_id);
        })->get();
        return view('admin.user.index')->with([
            'users' => $users
        ]);
    }

    public function create($company_id){
        $roles = Role::where('company_id','=',$company_id)->get();
        return view('admin.user.create')->with([
            'roles' => $roles
        ]);
    }

    public function store(Request $request,$company_id){
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $role = Role::where([
            ['company_id','=',$company_id],
            ['id','=',$request->role_id]
        ])->first();

        $user->companies()->attach($company_id, ['is_admin' => 0]);

        if($role){
            $user->roles()->attach($role->id);
        }

        return redirect()->route('users',['company_id' => $request->route('company_id')]);
    }

    public function edit($company_id,$id){
        $user = User::whereHas('companies',function($query) use($company_id){
            $query->where('company_id','=',$company_id);
        })->where('id','=',$id)->firstOrFail();
        $roles = Role::where('company_id','=',$company_id)->get();
        return view('admin.user.edit')->with([
            'roles' => $roles,
            'user'  => $user
        ]);
    }

    public function update(Request $request,$company_id,$id){

        $user = User::whereHas('companies',function($query) use($company_id){
            $query->where('company_id','=',$company_id);
        })->where('id','=',$id)->firstOrFail();

        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);
        $data = $request->only('name','email');
        $role = $user->role($company_id);
        if($role){
            $role->users()->detach($user->id);
        }
        if($request->password){
            $this->validate($request,[
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
            $data['password'] = bcrypt($request->password);
        }

        $role = Role::where([
            ['company_id','=',$company_id],
            ['id','=',$request->role_id]
        ])->first();


        $user->update($data);
        if($role){
            $user->roles()->attach($role->id);
        }

        return redirect()->route('users',['company_id' => $request->route('company_id')]);



    }

    public function delete($company_id,$id){
        User::whereHas('companies',function($query) use($company_id){
            $query->where('company_id','=',$company_id);
        })->where('id','=',$id)->delete();

        return redirect()->route('users',['company_id' => $company_id]);
    }

}
