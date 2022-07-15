<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $products = $this->product->with('images')->get();
       
        return response()->json($products,201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
            // dd($request->all());
            $product = $this->product->create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'category_id' => $request->category_id
            ]);

            if($request->file('image')){
                foreach($request->file('image') as $images){
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
        // dd($product);
        if(!isset($product)){
            return response()->json(['erro' => 'Produto pesquisado não existe']);
        }
        $product = $product->with('images')->findOrFail($id);
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
      
        // dd($request->file('image'));
        if(!isset($product)){
            return response()->json(['erro' => 'Produto pesquisado não existe']);
        }

        if($request->file('image')){
            $products = $product->with('images')->findOrFail($id);
            foreach($products->images as $images){
               Storage::disk('public')->delete($images->path);
               DB::table('images')->where('product_id', $id)->delete();
            }
        }

        //$product->fill($request->all());

     

        if($request->file('image')){
            foreach($request->file('image') as $images){
                //Storage::disk('public')->delete($images->path);
                $image = $images;
                $nameImage = $image->store('imagens', 'public');

                $this->image->create([
                    'path' => $nameImage,
                    'product_id' =>  $product->id
                ]);

            }
        }
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->user_id =  $request->user_id;
        $product->category_id =  $request->category_id;
        $product->save();
        // $this->product->update([
        //     'name' => $request->name,
        //     'price' => $request->price,
        //     'description' => $request->description,
        //     'user_id' => $request->user_id,
        //     'category_id' => $request->category_id
        // ]);

        return response()->json($product,201); 

       

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
        if(!isset($product)){
            return response()->json(['erro' => 'Recurso pesquisado não existe']);
        }
        $products = $product->with('images')->findOrFail($id);
        if(isset($products)){
            foreach($products->images as $images){
                Storage::disk('public')->delete($images->path);
                DB::table('images')->where('product_id', $id)->delete();
             }
        }
      
        $product->delete();
        return response()->json(['message' => 'O produto foi removido com sucesso'], 200) ;
    }
}
