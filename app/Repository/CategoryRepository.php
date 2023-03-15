<?php

namespace App\Repository;

use App\Models\Category;

class CategoryRepository
{
    public function __construct(
       protected Category $model
    ){}
    
    public function getAllCategories()
    {
        return  $this->model->get();
    }

    public function getCategory($id) :Category
    {
        return $this->model->findOrFail($id);
    }
   
    public function store(array $data) :Category
    {
        $category =  $this->model->create([
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
      
        $category->delete();
        
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    }
}