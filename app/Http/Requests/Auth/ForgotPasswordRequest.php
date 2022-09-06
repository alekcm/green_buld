<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_forgot' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function getEmail(): string
    {
        return parent::validated('email_forgot');
    }

    public function messages(): array
    {
        return [
            'email_forgot.exists' => 'Пользователь с указанной почтой не зарегистрирован',
        ];
    }
}
