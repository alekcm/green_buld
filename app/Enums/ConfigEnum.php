<?php

namespace App\Enums;

class ConfigEnum
{
    const EMAILS = 'emails';
    const SECTIONS = 'sections';
    const PURCHASING_CATEGORIES = 'purchasing_categories';

    const CONFIGS = [
        self::EMAILS => 'email',
        self::SECTIONS => 'разделы',
        self::PURCHASING_CATEGORIES => 'категории закупок',
    ];

    public static function toUpper($attr): string
    {
        $name = self::CONFIGS[$attr];
        return mb_strtoupper(mb_substr($name, 0, 1)) . mb_substr($name, 1);
    }
}
