<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        return [
            'table_no' => ['required', 'integer', 'min:1', 'max:15'],
            'total' => ['numeric', 'min:0'],
        ];
    }


    /**
     * @return array
     */
    public function messages()
    {
        return [
            'table_no.required' => 'Va rugam sa specificati masa.',
        ];
    }
}
