<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderDishRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => ['required', 'min:1', 'integer'],
            'dish_id' => [
                'required',
                'integer',
                Rule::exists('dishes', 'id'),
                Rule::unique('order_dishes','dish_id')
                    ->where('order_id', $this->order),
            ],

//            Rule::exists('orders', $this->order)
//                ->where('paid_at', null)
        ];
    }

    public function messages()
    {
        return [
          'dish_id.unique' => 'You already have this dish on the order.',
        ];
    }
}
