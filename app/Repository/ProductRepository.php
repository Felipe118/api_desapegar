<?php

namespace App\Repository;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    /**
     * @param $id
     * @return Product
     */

    public function getProduct($id)
    {
        return $this->enity->findOrFail($id)->with('images')->get();
    }

    /**
     * @param array $data
     * @param $image
     * @return Product
     */

    public function store(array $data,array $images) :Product
    {
        $product = $this->enity->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id']
        ]);

        $this->storeImages($images,$product->id);

        return $product;
    }

    /**
     * @param array $images
     * @param $id
     */

    public function storeImages(array $images,$productId)
    {
        foreach($images as $image){
            $nameImage = $image->store('imagens', 'public');

            Image::create([
                'path' => $nameImage,
                'product_id' =>  $productId
            ]);

        }
    }

    public function deleteImages($product,$id)
    {
        
        $products = $product->with('images')->findOrFail($id);
        foreach($products->images as $image){
            Storage::disk('public')->delete($image->path);
            DB::table('images')->where('product_id', $id)->delete();
        }
    }

    /**
     * @param array $data
     * @param array $images
     * @param $id
     * @return Product
     */

    public function update(array $data, array $images, $id)
    {
        $product = $this->enity->find($id);
        if($product == null){
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        $this->deleteImages($product,$id);

        $product->update($data);
        $this->storeImages($images,$id);

        return $product;
    }

    public function delete($id)
    {
        $product = $this->enity->find($id);
        if($product === null){
            return response()->json(['erro' => 'Categoria pesquisado não existe'], 404) ;
        }
        $this->deleteImages($product,$id);
        
        $product->delete();
        
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    }
}