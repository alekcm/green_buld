<?php

namespace App\Http\Requests\Web\Feedbacks;

use App\Models\Config;
use Illuminate\Foundation\Http\FormRequest;

class FeedbackStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'section' => ['nullable',],
            'purchasing_category' => ['nullable',],
            'question' => ['required', 'string',],
        ];
    }

    public function validated($key = null, $default = null)
    {
        if (!is_null($key)) {
            return parent::validated($key, $default);
        } else {
            $validated = parent::validated();
            $config = Config::first();

            return [
                'name' => $validated['name'],
                'section' => collect($config->sections)->get($validated['section']),
                'purchasing_category' => collect($config->purchasing_categories)->get($validated['purchasing_category']),
                'question' => $validated['question'],
            ];
        }
    }
}
