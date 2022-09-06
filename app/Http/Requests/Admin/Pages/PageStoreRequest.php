<?php

namespace App\Http\Requests\Admin\Pages;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class PageStoreRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge([
            'show_main' => $this->has('show_main'),
            'is_published' => $this->has('is_published'),
            'available' => array_keys($this->input('available', [])),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:pages,title,' . $this->input('id'),],
            'order' => ['required', 'integer', 'min:0',],
            'parent_id' => ['nullable', 'integer', 'exists:pages,id'],
            'content' => ['nullable', 'string',],
            'show_main' => ['required', 'boolean',],
            'is_published' => ['required', 'boolean',],
            'icon' => [
                'nullable',
                'string',
            ],
            'available' => ['nullable', 'array', 'min:0'],
            'available.*' => ['nullable', 'integer', Rule::in(array_keys(UserRoleEnum::AVAILABLE_ROLES))],
        ];
    }

    public function validated($key = null, $default = null)
    {
        if (!is_null($key)) {
            return parent::validated($key, $default);
        } else {

            $validated = parent::validated();

            if (is_null($validated['icon'])) {
                unset($validated['icon']);
            }

            if (!is_null($validated['parent_id'])) {
                unset($validated['available']);
            }

            return $validated;
        }
    }

    public function getPageContent(): string|null
    {
        return $this->validated('content');
    }
}
