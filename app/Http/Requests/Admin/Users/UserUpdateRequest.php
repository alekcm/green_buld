<?php

namespace App\Http\Requests\Admin\Users;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255',],
            'email' => ['required', 'email', 'unique:users,email,' . $this->route('id'),],
            'password' => [
                'nullable',
                'string',
                'min:' . config('app.user.password.min'),
                ],
            'role' => ['required', 'integer', Rule::in(array_keys(UserRoleEnum::ROLES))],
        ];
    }

    public function validated($key = null, $default = null)
    {
        if (!is_null($key)) {
            return parent::validated($key, $default);

        } else {
            $validated = parent::validated();
            return array_merge([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],

            ], (is_null($validated['password'])
                ? []
                : ['password' => $validated['password']])
            );
        }
    }
}
