<?php

namespace App\Repository;

use App\Models\Category;

class CategoryRepository
{
    public function __construct(Category $category)
    { 
        $this->enity = $category; 
    }
    
    public function getAllCategories()
    {
        return  $this->enity->get();
    }

    public function getCategory($id) :Category
    {
        return $this->enity->findOrFail($id);
    }
   
    public function store(array $data) :Category
    {
        $category =  $this->enity->create([
            'name_category' => $data['name_category'],
        ]);
        return $category;
    }

    public function update(array $data, $id) :Category
    {
        $category = $this->getCategory($id);
        if($category == null){
         return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->getCategory($id);
        if($category === null){
            return response()->json(['erro' => 'Categoria pesquisado não existe'], 404) ;
        }
        $category->delete();
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    }
}