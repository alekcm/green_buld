<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    const PUBLIC_FOLDER = 'public';

    /**
     * @param UploadedFile $file
     * @param string $path
     * @return string|null
     */
    public static function saveFile(UploadedFile $file, string $path): ?string
    {
        try {
            $result = null;

            if ($file->isValid()) {
                $result = Storage::disk()->putFile(self::PUBLIC_FOLDER . '/' . $path, $file);
                $result = $result ? basename($result) : null;
            }

            return $result;

        } catch (Exception $exception) {
            Log::error('Saving Uploaded file error');
            return null;
        }
    }

    /**
     * @param string $base
     * @param string $path
     * @param string $extension
     * @return string|null
     */
    public static function saveBase64(string $base, string $path, string $extension): ?string
    {
        try {
            if (!$encoded = base64_decode($base)) {
                return null;
            }
            $fileName = Str::random(40) . '.' . $extension;
            $result = Storage::disk()->put(self::PUBLIC_FOLDER . '/' . $path . '/' . $fileName, $encoded);

            return $result ? $fileName : null;
        } catch (Exception $exception) {
            Log::error('Saving base64 file error');
            return null;
        }
    }

    public static function deleteFile(string $name, string $path): bool
    {
        return Storage::disk()->delete(self::PUBLIC_FOLDER . '/' . $path . '/' . $name);
    }
}
