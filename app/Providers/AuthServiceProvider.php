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

        # Usuário comum
        Gate::define('member', function($user) {
            return $user->role('member');
        });

        # admin 
        Gate::define('admin', function ($user) {
            return $user->role('admin');
        });

    }
}
