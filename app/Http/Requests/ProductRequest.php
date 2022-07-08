<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
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
            'name' => ['required', 'min:3'],
            'price' => 'required',
            'description' => 'required',
            // 'image' => ['required','file'],
            'user_id' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O :attribute é obrigatório',
            'name.min' => 'O nome do produto deve conter mais do que 3 caracteres',
            // 'image.required' => 'Deve conter pelo menos uma imagem do produto!',
            // 'image.mimes' => 'O arquivo deve ser uma imagem do tipo .png ou .jpg',
            'category_id.required' => 'A categoria é obrigatório '
        ];
    }
}
