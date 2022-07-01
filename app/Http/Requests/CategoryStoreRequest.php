<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
{
    public function __construct(Category $category)
    {
        $this->categories = $category;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_category' => ['required', 'min:3', Rule::unique('categories')->ignore($this->categories->id)]
        ];
    }
    public function messages()
    {
        return [
            'name_category.unique' => 'A categoria já existe',
            'name_category.required' => 'O nome da categoria é obrigatório',
            'name_category.min' => 'O nome da categoria deve ter mais de 3 caracteres'
        ];
    }
}
