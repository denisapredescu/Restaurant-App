<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDishRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
//        'name' => ['required', 'max:50', 'string', Rule::unique('dishes', 'name')->parameter("dish")],
        return [
            'name' => ['required', 'max:50', 'string', Rule::unique('dishes', 'name')->ignore($this->dish)],
            'price' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'integer', 'min:0'],
            'ingredients' => 'required|max:300|string',
        ];
    }
}
