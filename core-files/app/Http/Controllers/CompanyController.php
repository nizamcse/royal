<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\User;
use Illuminate\Http\Request;
use Auth;
use File;

class CompanyController extends Controller
{
    public function index(){
        if(Auth::user()->super_admin){
            $companies = Company::all();
        }
        else{
            $userId = Auth::user()->id;
            $companies = Company::whereHas('users',function($query) use($userId){
                $query->where('user_id',$userId);
            })->get();
        }
        return view('admin.company.index')->with([
            'companies' => $companies,
        ]);
    }

    public function create(){
        return view('admin.company.create');
    }

    public function show($id){
        $userId = Auth::user()->id;
        $company = Company::whereHas('users',function($query) use($userId){
            $query->where('user_id',$userId);
        })->where('id','=',$id)->firstOrFail();
        return view('admin.company.show')->with([
            'company'   => $company
        ]);
    }

    public function edit($id){
        $company = Company::findOrFail($id);
        return view('admin.company.edit')->with([
            'company'   => $company
        ]);
    }

    public function getAdmins(Request $request){
        $admins = [];
        if($request->name){
            $admins = User::where('name','like','%'.$request->name.'%')->get();
        }else if($request->email){
            $admins = User::where('email','like','%'.$request->email.'%')->get();
        }

        return response()->json($admins,200);
    }

    public function store(Request $request){
        $user =User::whereEmail($request->email)->first();
        if($user){
            $this->validate($request,[
                'name'          => ['required', 'string', 'max:255'],
                'contact_no'    => ['required']
            ]);
        }else{
            $this->validate($request,[
                'name'          => ['required', 'string', 'max:255'],
                'admin_name'    => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'      => ['required', 'string', 'min:6', 'confirmed'],
                'contact_no'    => ['required']
            ]);
            $user = $this->createUser($request->only('admin_name','email','password'));
        }

        $company = Company::create([
            'name'          => $request->name,
            'email'         => $request->company_email,
            'address'       => $request->address,
            'contact_no'    => $request->contact_no,
        ]);

        if($request->file('logo')){
            $name = "logo.".$request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move('images/'.str_slug($company->name,'-'),$name);
            $name = 'images/'.str_slug($company->name,'-').$name;
            $company->fill([
                'logo' => $name
            ]);
        }


        $user->companies()->attach($company->id, ['is_admin' => 1]);
        return redirect()->route('companies');
    }

    public function update(Request $request,$id){
        $company = Company::findOrFail($id);
        $data = $request->all();
        $path = public_path().'/'.$company->logo;
        if($request->file('logo')){
            File::delete($path);
            $name = "logo.".$request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move('images/'.str_slug($company->name,'-'),$name);
            $name = 'images/'.str_slug($company->name,'-').'/'.$name;
            $data['logo'] = $name;
        }
        $company->update($data);
        $company->admin()->detach();
        $user = User::findOrFail($request->user_id);

        $company->users()->attach($user->id,[
            'is_admin'  => 1
        ]);
        return redirect()->route('companies');
    }

    public function updatePassword(Request $request){
        $company = Company::findOrFail($request->company_id);
        $user = $company->admin->first();
        $user->update([
            'password'  => bcrypt($request->password)
        ]);
        return response()->json([
            'status'    => true,
            'text'      => 'Successfully updated password'
        ],200);
    }

    public function delete($id){
        Company::findOrFail($id)->delete();
        return redirect()->route('companies');
    }

    private function createUser($data){
        return User::create([
            'name'          => $data['admin_name'],
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
        ]);
    }

    public function findUser(Request $request){
        return User::whereEmail($request->email)->first();
    }
}
