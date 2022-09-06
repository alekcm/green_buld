<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property array $emails
 * @property array $sections
 * @property array $purchasing_categories
 *
 * @property-read string $emails_to_string
 * @property-read string $sections_to_string
 * @property-read string $purchasing_categories_to_string
 *
 * @mixin Eloquent
 */
class Config extends Model
{
    protected $fillable = [
        'emails',
        'sections',
        'purchasing_categories',
    ];

    protected $casts = [
        'emails' => 'array',
        'sections' => 'array',
        'purchasing_categories' => 'array',
    ];

    public function getEmailsToStringAttribute(): string
    {
        return $this->attributeToString($this->emails);
    }

    public function getSectionsToStringAttribute(): string
    {
        return $this->attributeToString($this->sections);
    }

    public function getPurchasingCategoriesToStringAttribute(): string
    {
        return $this->attributeToString($this->purchasing_categories);
    }

    public function attributeToString($attr): string
    {
        return implode(config('app.config.separator.implode'), $attr);
    }
}
