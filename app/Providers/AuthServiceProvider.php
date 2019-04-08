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
            $admins = explode(',', trim(config('copaco.superadmins_usernames')));

            return ( in_array($user->username, $admins) and $user->username );

        });
    }
}
