<?php

use App\Services\ImageUploader;
use Illuminate\Http\UploadedFile;

it('uploads an image and returns the secure URL', function () {
    $cloudinaryMock = Mockery::mock('alias:CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary');
    $secureUrl = 'https://fake.cloudinary.com/image.jpg';
    $cloudinaryMock->shouldReceive('upload')->once()->andReturnUsing(function () use ($secureUrl) {
        $cloudinaryResponse = new stdClass();
        $cloudinaryResponse->secure_url = $secureUrl;

        return new class($cloudinaryResponse) {
            private $response;

            public function __construct($response)
            {
                $this->response = $response;
            }

            public function getSecurePath()
            {
                return $this->response->secure_url;
            }
        };
    });;
    $imageUploader = new ImageUploader();
    $uploadedFileMock = Mockery::mock(UploadedFile::class);
    $uploadedFileMock->shouldReceive('getRealPath')->andReturn('/path/to/fake/image.jpg');
    $result = $imageUploader->upload($uploadedFileMock);

    expect($result)->toBe($secureUrl);
});
