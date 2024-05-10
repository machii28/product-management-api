<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;

class InventoryManagement
{
    public function add(Product $product, int $quantity): Product
    {
        $transaction = new Transaction();

        $transaction->transaction_type = Transaction::TRANSACTION_RETURN;
        $transaction->quantity_changed = $quantity;
        $transaction->product_id = $product->id;
        $transaction->save();

        $product->quantity_in_stocks = $product->quantity_in_stocks + $quantity;
        $product->save();
        $product = $product->fresh();

        return $product;
    }

    public function deduct(Product $product, int $quantity): Product
    {
        if ($product->quantity_in_stocks === 0) {
            throw new \InvalidArgumentException("Cannot deduct inventory. Quantity is already 0.");
        }

        if ($quantity > $product->quantity_in_stocks) {
            throw new \InvalidArgumentException("Cannot deduct inventory. Requested quantity exceeds available quantity.");
        }

        $transaction = new Transaction();
        $transaction->transaction_type = Transaction::TRANSACTION_PURCHASE;
        $transaction->quantity_changed = $quantity;
        $transaction->product_id = $product->id;
        $transaction->save();

        $product->quantity_in_stocks = $product->quantity_in_stocks - $quantity;
        $product->save();
        $product = $product->fresh();

        return $product;
    }
}
