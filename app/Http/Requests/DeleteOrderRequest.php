<?php

namespace App\Http\Requests;

use App\Rules\OrderIsNotPaid;
use Illuminate\Foundation\Http\FormRequest;

class DeleteOrderRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => [new OrderIsNotPaid],
        ];
    }
}
