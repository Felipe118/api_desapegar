<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
     protected  ProductRepository $repository,
     protected Product $product
    ){}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->with('images')->get();
       
        return response()->json($products,201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        $product = $this->repository->store($request->all(),$request->file('image'));
        return new ProductResource($product);
    }

    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return ProductResource
     */
    public function show($id)
    {
        $product = $this->repository->getProduct($id);  
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return ProductResource
     */
    public function update(Request $request, $id)
    {
        $product = $this->repository->update($request->all(),$request->file('image'),$id);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage. 
     *
     * @param  int  $id
     * @return string $product
     */
    public function destroy($id)
    {
        $product = $this->repository->delete($id);

        return $product;
    }
}
