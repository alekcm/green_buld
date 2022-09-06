<?php

namespace App\Http\Requests\Admin\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class IconStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon' => [
                'required',
                'image',
                'mimes:' . config('app.page.icon.mimes'),
                'max:' . config('app.page.icon.max_size'),
            ]
        ];
    }

    public function getIcon(): array|UploadedFile|null
    {
        return $this->file('icon');
    }
}
