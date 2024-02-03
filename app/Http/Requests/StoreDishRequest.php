<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // pentru ca acum sunt admin; daca eram om obisnuit, ar fi putut sa nu fiu mereu autentificat
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50', 'string', 'unique:dishes,name'],
            'price' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'integer', 'min:0'],
            'ingredients' => 'required|max:300|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Va rugam sa completati numele.',
            'name.unique' => 'Acest nume a fost folosit deja.',
        ];
    }
}
