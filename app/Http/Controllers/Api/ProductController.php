<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(Product $product, Image $image)
    {
        $this->product = $product;
        $this->image = $image;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
            dd($request->file('image'));
            $product = $this->product->create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'category_id' => $request->category_id
            ]);

            if($request->file('image')){
                foreach($request->file('') as $images){
                    $image = $images;
                    $nameImage = $image->store('imagens', 'public');

                    $this->image->create([
                        'path' => $nameImage,
                        'product_id' =>  $product->id
                    ]);

                }
            }

         return response()->json($product,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->find($id);
        if(isset($product)){
            return response()->json(['erro' => 'Produto pesquisado não existe']);
        }
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = $this->product->find($id);
        if(isset($product)){
            return response()->json(['erro' => 'Produto pesquisado não existe']);
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = 'image';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
        if(isset($product)){
            return response()->json(['erro' => 'Recurso pesquisado não existe']);
        }
        $product->delete();
        return response()->json(['message' => 'O produto foi removido com sucesso'], 200) ;
    }
}
