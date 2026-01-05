<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;
use App\Contracts\Services\ProductServiceInterface;

class AddCartItemRequest extends BaseRequest
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

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
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->productService->isStockAvailable($this->input('product_id'), $this->input('quantity'))) {
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
            'product_id.required' => $this->errorMessages['required'],
            'product_id.integer' => $this->errorMessages['integer'],
            'product_id.exists' => $this->errorMessages['exists'],
            'quantity.required' => $this->errorMessages['required'],
            'quantity.integer' => $this->errorMessages['integer'],
            'quantity.min' => $this->errorMessages['min']
        ];
    }
}
