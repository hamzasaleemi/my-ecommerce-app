<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;
use App\Rules\WithinStockQuantity;
use App\Contracts\Repositories\ProductRepositoryInterface;

class CartUpdateItemRequest extends BaseRequest
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
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
            'product_id' => 'required|integer|exists:products,id|exists:cart_items,product_id,user_id,' . $this->user()->id,
            'quantity' => ['required', 'integer', 'min:1', new WithinStockQuantity($this->productRepository, $this->input('product_id'))],
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
            'quantity.required' => $this->errorMessages['required'],
            'quantity.integer' => $this->errorMessages['integer'],
            'quantity.min' => $this->errorMessages['min']
        ];
    }
}
