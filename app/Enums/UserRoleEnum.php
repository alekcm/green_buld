<?php

namespace App\Enums;

use App\Enums\Abstr\DictionaryEnum;

final class UserRoleEnum extends DictionaryEnum
{
    const ADMIN = 1;
    const ORGANIZER = 2;
    const TYPICAL_USER = 3;

    const ROLES = [
        self::ADMIN => 'Администратор',
        self::ORGANIZER => 'Организатор',
        self::TYPICAL_USER => 'Типовой пользователь',
    ];

    const AVAILABLE_ROLES = [
        self::ORGANIZER => 'Организатор',
        self::TYPICAL_USER => 'Типовой пользователь',
    ];

    protected static array $enumItems = self::ROLES;
}
