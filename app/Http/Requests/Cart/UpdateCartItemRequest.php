<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;
use App\Contracts\Services\CartItemServiceInterface;

class UpdateCartItemRequest extends BaseRequest
{
    private CartItemServiceInterface $cartItemService;

    public function __construct(CartItemServiceInterface $cartItemService)
    {
        parent::__construct();
        $this->cartItemService = $cartItemService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->cartItemService->isStockAvailable($this->route('id'), $this->input('quantity'))) {
                $validator->errors()->add(
                    'quantity',
                    'Insufficient stock available for this product.'
                );
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'quantity.required' => $this->errorMessages['required'],
            'quantity.integer' => $this->errorMessages['integer'],
            'quantity.min' => $this->errorMessages['min']
        ];
    }
}
