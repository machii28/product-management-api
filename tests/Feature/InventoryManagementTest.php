<?php

uses( \Illuminate\Foundation\Testing\DatabaseTransactions::class);

it('can add inventory to a product', function () {
    $product = \App\Models\Product::factory()->create();
    $productQuantity = $product->quantity_in_stocks;
    $inventoryManagement = new \App\Services\InventoryManagement();
    $quantityToAdd = 5;

    $result = $inventoryManagement->add($product, $quantityToAdd);

    expect($result->quantity_in_stocks)->toBe($productQuantity + $quantityToAdd);
    $product->fresh();
    expect($product->quantity_in_stocks)->toBe($productQuantity + $quantityToAdd);
});

it('throws exception when deducting inventory from a product with zero quantity', function () {
    $product = \App\Models\Product::factory()->create(['quantity_in_stocks' => 0]);
    $inventoryManagement = new \App\Services\InventoryManagement();

    expect(function () use ($inventoryManagement, $product) {
        $inventoryManagement->deduct($product, 1);
    })->toThrow(\InvalidArgumentException::class, 'Cannot deduct inventory. Quantity is already 0');
});

it('throws exception when deducting more inventory than available', function () {
    $product = \App\Models\Product::factory()->create(['quantity_in_stocks' => 5]);
    $inventoryManagement = new \App\Services\InventoryManagement();

    expect(function () use ($inventoryManagement, $product) {
        $inventoryManagement->deduct($product, 10);
    })->toThrow(\InvalidArgumentException::class, 'Cannot deduct inventory. Requested quantity exceeds available quantity.');
});

it('can deduct inventory from a product', function () {
    $product = \App\Models\Product::factory()->create(['quantity_in_stocks' => 10]);
    $productQuantity = $product->quantity_in_stocks;
    $inventoryManagement = new \App\Services\InventoryManagement();
    $quantityToDeduct = 5;

    $result = $inventoryManagement->deduct($product, $quantityToDeduct);

    expect($result->quantity_in_stocks)->toBe($productQuantity - $quantityToDeduct);
    $product->fresh();
    expect($product->quantity_in_stocks)->toBe($productQuantity - $quantityToDeduct);
});
