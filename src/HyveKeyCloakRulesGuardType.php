<?php

namespace HyveKeyCloakRules;

use CloakPort\GuardContract;
use CloakPort\GuardTypeContract;
use CloakPort\Keycloak\TokenGuard as KeycloakGuard;
use CloakPort\Passport\TokenClientGuard as PassportClientGuard;
use CloakPort\Passport\TokenUserGuard as PassportUserGuard;
use CloakPort\TokenGuard as DefaultGuard;
use HyveKeyCloakRules\Guards\HyveKeyCloakRulesGuard;

enum HyveKeyCloakRulesGuardType implements GuardTypeContract
{
    case KEYCLOAK;
    case HYVE_KEYCLOAK_RULES;
    case PASSPORT_CLIENT;
    case PASSPORT_USER;
    case DEFAULT;

    public static function load(string $backend): GuardTypeContract
    {
        return match(strtolower($backend)) {
            'hyve_keycloak_rule' => HyveKeyCloakRulesGuardType::HYVE_KEYCLOAK_RULES,
            'keycloak' => HyveKeyCloakRulesGuardType::KEYCLOAK,
            'passport_client' => HyveKeyCloakRulesGuardType::PASSPORT_CLIENT,
            'passport_user' => HyveKeyCloakRulesGuardType::PASSPORT_USER,
            default => HyveKeyCloakRulesGuardType::DEFAULT
        };
    }

    public function loadFrom(array $config): GuardContract
    {
        return match ($this) {
            self::HYVE_KEYCLOAK_RULES => HyveKeyCloakRulesGuard::load($config),
            self::KEYCLOAK => KeycloakGuard::load($config),
            self::PASSPORT_CLIENT => PassportClientGuard::load($config),
            self::PASSPORT_USER => PassportUserGuard::load($config),
            self::DEFAULT => new DefaultGuard()
        };
    }
}
