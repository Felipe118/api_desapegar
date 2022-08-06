<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::all();
    }
}