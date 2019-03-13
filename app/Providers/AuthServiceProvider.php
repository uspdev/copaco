<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Auth;

use App\Policies\EquipamentoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       # 'App\Model' => 'App\Policies\ModelPolicy',
        Equipamento::class => EquipamentoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        # equipamentos policy
        Gate::resource('equipamentos', 'App\Policies\EquipamentoPolicy');

        # admin 
        Gate::define('admin', function ($user) {
            $admins_id = explode(',', trim(config('copaco.superadmins_ids')));
            $admins_senhaunica = explode(',', trim(config('copaco.superadmins_senhaunica')));
            $admins_ldap = explode(',', trim(config('copaco.superadmins_ldap')));

            return
                (in_array($user->id, $admins_id) and $user->id) or
                (in_array($user->username_senhaunica, $admins_senhaunica) and $user->username_senhaunica) or
                (in_array($user->username_senhaunica, $admins_ldap) and $user->username_ldap);

            //Auth::user()
            //$codpesAdmins = explode(',', trim(env('SUPERADMIN_IDS')));
            //return Auth::check() && in_array(Auth::user()->id, $codpesAdmins);
        });
    }
}
