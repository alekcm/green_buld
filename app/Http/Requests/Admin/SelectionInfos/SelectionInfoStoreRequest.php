<?php

namespace App\Http\Requests\Admin\SelectionInfos;

use Illuminate\Foundation\Http\FormRequest;

class SelectionInfoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
//        dd($this->input());
        return [
            'file' => 'string',
        ];
    }

    public function getFilename(): string
    {
        return $this->input('file');
    }
}
