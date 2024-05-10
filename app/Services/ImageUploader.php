<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploader
{
    public function upload(UploadedFile $file): string
    {
        $path = $file->store('public/image');

        return Storage::url($path);
    }
}
