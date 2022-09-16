<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository
{
    public function __construct(Product $product)
    { 
        $this->enity = $product;
    }
    
    public function getAllProducts()
    {
        return  $this->enity->get();
    }

    public function store()
    {

    }
}