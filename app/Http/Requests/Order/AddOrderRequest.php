<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\BaseRequest;
use App\Contracts\Services\ProductServiceInterface;

class AddOrderRequest extends BaseRequest
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
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|integer|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $orderItems = $this->input('order_items', []);

            foreach ($orderItems as $index => $item) {
                if (!$this->productService->isStockAvailable($item['product_id'], $item['quantity'])) {
                    $validator->errors()->add(
                        "order_items.{$index}.quantity",
                        'Insufficient stock available for the product: ' . $this->productService->getById($item['product_id'])->name . '. Only ' . $this->productService->getById($item['product_id'])->stock_quantity . ' left in stock.'
                    );
                }
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
            'order_items.required' => $this->errorMessages['required'],
            'order_items.array' => $this->errorMessages['array'],
            'order_items.min' => $this->errorMessages['min'],
            'order_items.*.product_id.required' => $this->errorMessages['required'],
            'order_items.*.product_id.integer' => $this->errorMessages['integer'],
            'order_items.*.product_id.exists' => $this->errorMessages['exists'],
            'order_items.*.quantity.required' => $this->errorMessages['required'],
            'order_items.*.quantity.integer' => $this->errorMessages['integer'],
            'order_items.*.quantity.min' => $this->errorMessages['min'],
        ];
    }
}
