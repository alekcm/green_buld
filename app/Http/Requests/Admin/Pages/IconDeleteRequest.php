<?php

namespace App\Http\Requests\Admin\Pages;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;

class IconDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:pages,id'],
        ];
    }

    public function getPage(): ?Page
    {
        return Page::findOrFail($this->validated('id'));
    }
}
