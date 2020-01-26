<?php

namespace App\Http\Middleware;

use App\Model\Company;
use Closure;
use Auth;

class CompanyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->route('company_id')){
            if(auth()->check()){
                $userId = $request->user()->id;
                $company = Company::whereHas('users',function($query) use($userId){
                    $query->where('user_id',$userId);
                })->first();
                $user = Auth::user();
                $user_data = [
                    'id'    =>  $user->id,
                    'name'  =>  $user->name,
                    'email'  =>  $user->email,
                    'company'   => (object)[
                        'id'  => $company->id,
                        'name'  => $company->name,
                        'phone'  => $company->contact_no,
                        'email'  => $company->email,
                        'address'  => $company->address,
                    ]
                ];
            }else{
                return redirect()->route('login');
            }
            $request->request->add([
                '_user_info'    => $user_data
            ]);

            return $company ? $next($request) : abort(404);
        }
        abort(404);
    }
}
