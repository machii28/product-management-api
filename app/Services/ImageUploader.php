<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploader
{
    public function upload(UploadedFile $file): string
    {
        return Cloudinary::upload($file->getRealPath())->getSecurePath();
    }
}
