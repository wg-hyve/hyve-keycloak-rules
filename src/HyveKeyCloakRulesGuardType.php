<?php

namespace HyveKeyCloakRules;

use HyveKeyCloakRules\HyveKeycloakRulesGuard;
use CloakPort\GuardContract;
use CloakPort\GuardTypeContract;
use CloakPort\TokenGuard as DefaultGuard;
use CloakPort\Keycloak\TokenGuard as KeycloakGuard;
use CloakPort\Passport\TokenClientGuard as PassportClientGuard;
use CloakPort\Passport\TokenUserGuard as PassportUserGuard;

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
            'keycloak' => HyveKeyCloakRulesGuardType::KEYCLOAK,
            'passport_client' => HyveKeyCloakRulesGuardType::PASSPORT_CLIENT,
            'passport_user' => HyveKeyCloakRulesGuardType::PASSPORT_USER,
            'hyve_keycloak_rule' => HyveKeyCloakRulesGuardType::HYVE_KEYCLOAK_RULES,
            default => HyveKeyCloakRulesGuardType::DEFAULT
        };
    }

    public function loadFrom(array $config): GuardContract
    {
        return match ($this) {
            self::KEYCLOAK => KeycloakGuard::load($config),
            self::PASSPORT_CLIENT => PassportClientGuard::load($config),
            self::PASSPORT_USER => PassportUserGuard::load($config),
            self::HYVE_KEYCLOAK_RULES => HyveKeycloakRulesGuard::load($config),
            self::DEFAULT => new DefaultGuard()
        };
    }
}
