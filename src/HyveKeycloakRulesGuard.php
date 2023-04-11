<?php

namespace HyveKeyCloakRules;

use CloakPort\GuardContract;
use CloakPort\TokenGuard as ParentTokenGuard;
use Illuminate\Contracts\Auth\Guard;

class HyveKeycloakRulesGuard extends ParentTokenGuard implements Guard, GuardContract
{
    public static function load(array $config): self
    {
        return new self();
    }

    public function validate(array $credentials = [])
    {
        // any magic to valid your JWT
        return $this->check();
    }

    public function check()
    {
        dd(request()->path());
        return false;
    }

    public function name(): string
    {
        return 'hyve_keycloak_rule';
    }
}
