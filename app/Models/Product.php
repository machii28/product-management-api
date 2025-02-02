<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost_of_good',
        'selling_price',
        'quantity_in_stocks'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
