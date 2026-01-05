<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\BaseRequest;
use App\Contracts\Repositories\ProductRepositoryInterface;

class AddOrderRequest extends BaseRequest
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
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|integer|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $orderItems = $this->input('order_items', []);

            $products = $this->productRepository->get([
                'whereIn' => [
                    'field' => 'id',
                    'values' => array_column($orderItems, 'product_id'),
                ],
            ])->keyBy('id');

            foreach ($orderItems as $index => $item) {
                if (!isset($products[$item['product_id']]) || $item['quantity'] > $products[$item['product_id']]->stock_quantity) {
                    $product = $products[$item['product_id']] ?? null;
                    $validator->errors()->add(
                        "order_items.{$index}.quantity",
                        'Insufficient stock available for the product: ' . $product->name . '. Only ' . $product->stock_quantity . ' left in stock.'
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
