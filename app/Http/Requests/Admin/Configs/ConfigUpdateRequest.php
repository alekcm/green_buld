<?php

namespace App\Http\Requests\Admin\Configs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfigUpdateRequest extends FormRequest
{
    public function prepareForValidation()
    {
        if ($this->has('emails')) {
            $this->merge([
                'emails' => array_map(function (string $item) {
                    return trim($item);
                }, explode(config('app.config.separator.explode'), $this->input('emails', '')))
            ]);
        }

        if ($this->has('sections')) {
            $this->merge([
                'sections' => array_map(function (string $item) {
                    return trim($item);
                }, explode(config('app.config.separator.explode'), $this->input('sections', '')))
            ]);
        }

        if ($this->has('purchasing_categories')) {
            $this->merge([
                'purchasing_categories' => array_map(function (string $item) {
                    return trim($item);
                }, explode(config('app.config.separator.explode'), $this->input('purchasing_categories', '')))
            ]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'emails' => [
                Rule::requiredIf(!$this->has('sections') && !$this->has('purchasing_categories')),
                'array',
            ],
            'emails.*' => ['required', 'email'],
            'sections' => [
                Rule::requiredIf(!$this->has('emails') && !$this->has('purchasing_categories')),
                'array',
            ],
            'sections.*' => ['required', 'string'],
            'purchasing_categories' => [
                Rule::requiredIf(!$this->has('emails') && !$this->has('sections')),
                'array',
            ],
            'purchasing_categories.*' => ['required', 'string'],
        ];
    }
}
