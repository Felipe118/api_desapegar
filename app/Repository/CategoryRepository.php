<?php

namespace App\Repository;

use App\Models\Category;

class CategoryRepository
{
    public function __construct(Category $category)
    { 
        $this->entity = $category; 
    }
    
    public function getAllCategories()
    {
        return  $this->entity->get();
    }

    public function getCategory($id) :Category
    {
        return $this->entity->findOrFail($id);
    }
   
    public function store(array $data) :Category
    {
        $category =  $this->entity->create([
            'name_category' => $data['name_category'],
        ]);
        return $category;
    }

    public function update(array $data, $id) :Category
    {
        $category = $this->getCategory($id);
     
        $category->update($data);

        return $category;
    }

    public function delete($id)
    {
        $category = $this->getCategory($id);
        // if($category === null){
        //     return response()->json(['erro' => 'Categoria pesquisado não existe'], 404) ;
        // }
        $category->delete();
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    }
}