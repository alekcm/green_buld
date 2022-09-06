<?php

namespace App\Http\Requests\Admin\SelectionInfos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class FileStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:' . config('app.selection_info.mimes'),
            ]
        ];
    }

    public function getFile(): UploadedFile
    {
        return $this->file('file');
    }
}
