<?php

namespace App\Enums\Abstr;

use App\Entities\DataTransferObjects\DictionaryItem;
use Illuminate\Support\Collection;

abstract class DictionaryEnum
{
    protected static array $enumItems;

    /**
     * @return Collection
     */
    public static function all(): Collection
    {
        $objStatuses = collect();
        array_walk(static::$enumItems, function ($value, $key) use (&$objStatuses) {
            $objStatuses->add(new DictionaryItem($key, $value));
        });

        return $objStatuses;
    }

    /**
     * @param int $id
     *
     * @return DictionaryItem|null
     */
    public static function find(int $id): DictionaryItem|null
    {
        return static::$enumItems[$id]
            ? new DictionaryItem($id, static::$enumItems[$id])
            : null;
    }
}
