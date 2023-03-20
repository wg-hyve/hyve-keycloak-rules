<?php

namespace HyveKeyCloakRules\Http\Middleware;

use CloakPort\GuardContract;
use CloakPort\TokenGuard as ParentTokenGuard;
use HyveKeyCloakRules\HyveKeyCloakRules;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class TokenGuard extends ParentTokenGuard implements Guard, GuardContract
{
    public static function load(array $config): self
    {
        return new self();
    }

    public function validate(array $credentials = [])
    {
        if(empty(Auth::name()) || Auth::name() !== 'keycloak')
        {
            return;
        }
        // any magic to valid your JWT
        return $this->check();
    }

    public function check()
    {
        dd(Auth::getAllRules());

        $name = Route::currentRouteName();

        $test = HyveKeyCloakRules::where('route', $name)->firstOrFail();

        dd($test);
        if(in_array(Auth::getAllRules(), json_decode($test))){
            return true;
        }

        return false;
    }
}