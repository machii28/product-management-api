<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Product;
use App\Services\InventoryManagement;
use Illuminate\Http\Response;

class InventoryController extends Controller
{
    public function purchase(Product $product, InventoryRequest $request)
    {
        $inventoryManagement = app(InventoryManagement::class);

        return response()->json(
            $inventoryManagement->deduct($product, $request->get('quantity')),
            Response::HTTP_OK
        );
    }

    public function return(Product $product, InventoryRequest $request)
    {
        $inventoryManagement = app(InventoryManagement::class);

        return response()->json(
            $inventoryManagement->add($product, $request->get('quantity')),
            Response::HTTP_OK
        );
    }
}
