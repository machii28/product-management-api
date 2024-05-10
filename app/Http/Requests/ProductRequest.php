<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class ProductRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'cost_of_good' => 'numeric|required',
            'selling_price' => 'numeric|required',
            'quantity_in_stocks' => 'numeric|required'
        ];
    }
}
