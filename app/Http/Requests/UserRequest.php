<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function __construct(User $user)
    {
        $this->user = $user;
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
            'name' => ['required','min:3'],
            'phone' => ['required'],
            'email' => ['required','regex:/^.+@.+$/i',Rule::unique('users')->ignore($this->user->id)]
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attibute é obrigatório',
            'name.min' => 'O nome deve ter mais do que três caracteres',
            'email.unique' => 'O e-mail já foi cadastrado',
            'email.regex' => 'Digite um formato de e-mail válido'
        ];
        
    }
}
