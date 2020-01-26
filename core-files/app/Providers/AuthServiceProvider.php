<?php

namespace App\Providers;

use App\Model\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability,$params = null) {
            $company_id = $params[0] ?? null;
            $request = resolve(\Illuminate\Http\Request::class);
            $company_id = $request->route()->parameters()['company_id'] ?? $company_id;
            $company = $user->companies->where('id','=',$company_id)->first();
            if($company->pivot && $company->pivot->is_admin){
                return true;
            }
        });

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->slug, function($user,$params = null) use ($permission) {
                $request = resolve(\Illuminate\Http\Request::class);
                $company_id = $params[0] ?? null;
                $company_id = $request->route()->parameters()['company_id'] ?? $company_id;
                $user_id = $user->id;
                $data = [
                    'user_id'       => $user_id,
                    'company_id'    => $company_id
                ];
                $permissions = Permission::whereHas('roles',function($query) use($data){
                    $user_id = $data['user_id'];
                    $query->whereHas('users',function($q) use($user_id){
                        $q->where('user_id','=',$user_id);
                    })->where('company_id','=',$data['company_id']);
                })->whereId($permission->id)->count();

                return $permissions > 0;

            });
        }

    }

    protected function getPermissions(){
        $permissions = Permission::all();
        return $permissions;
    }
}
