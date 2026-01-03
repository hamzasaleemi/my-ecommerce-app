<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;

class CartRemoveItemRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id|exists:cart_items,product_id,user_id,' . $this->user()->id,
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_id.required' => $this->errorMessages['required'],
            'product_id.integer' => $this->errorMessages['integer'],
            'product_id.exists' => $this->errorMessages['exists'],
        ];
    }
}
