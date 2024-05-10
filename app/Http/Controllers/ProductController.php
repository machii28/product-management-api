<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageUploader;
use Illuminate\Database\Eloquent\Model;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class ProductController extends Controller
{
    use DisableAuthorization;

    protected $model = Product::class;

    protected $request = ProductRequest::class;

    protected function alwaysIncludes(): array
    {
        return ['images'];
    }

    protected function afterStore(\Orion\Http\Requests\Request $request, Model $entity)
    {
        $uploader = app(ImageUploader::class);
        $paths = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            if (!is_array($images)) {
                $images = [$images];
            }

            foreach ($images as $image) {
                $paths[] = $uploader->upload($image);
            }

            foreach ($paths as $path) {
                $productImage = new ProductImage();
                $productImage->product_id = $entity->id;
                $productImage->url = $path;
                $productImage->save();
            }
        }
    }
}
