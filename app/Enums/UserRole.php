<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Officer = 'officer';
    case Customer = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Officer => 'Field Officer',
            self::Customer => 'Citizen',
        };
    }
}
