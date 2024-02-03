<?php

namespace App\Http\Requests;

use App\Rules\OrderIsNotPaid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'order_id' => $this->order,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_id' => ['bail', new OrderIsNotPaid],
            'table_no' => [
                'required',
                'integer',
                'min:1',
                'max:15',
                Rule::unique('orders', 'table_no')
                    ->where('paid_at', null)
                    ->ignore($this->order),
            ],
        ];
    }
}
