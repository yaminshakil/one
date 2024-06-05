<?php

namespace App\Providers;

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

        // the gate checks if the user is an admin or a superadmin or Redport employee
        Gate::define('accessAdmin', function($user) {
            return (strpos($user->email,'redport-ia.com')!==false);
        });

        // the gate checks if the user is a company manager
        Gate::define('manageCompany', function($user) {
            return $user->hasRole('manager');
        });

        // the gate checks if the user is a company manager
        Gate::define('accessCompany', function($user) {
            return $user->hasRole('manager') || $user->hasRole('user');
        });

        // the gate checks if the user is a regular user (with a company?)
        Gate::define('accessProfile', function($user) {
            return $user->hasRole('user');
        });
    }
}
