<?php

namespace HyveKeyCloakRules;

use HyveKeyCloakRules\HyveKeycloakRulesGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class HyveKeycloakRulesProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('hyve_keycloak_rule', function ($app, $name, array $config) {
            return new HyveKeycloakRulesGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
    }
}