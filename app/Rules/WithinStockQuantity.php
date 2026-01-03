<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Contracts\Repositories\ProductRepositoryInterface;

class WithinStockQuantity implements ValidationRule
{
    private ProductRepositoryInterface $productRepository;
    private int $productId;

    public function __construct(ProductRepositoryInterface $productRepository, int $productId)
    {
        $this->productRepository = $productRepository;
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = $this->productRepository->find($this->productId);
        if ($value > $product->stock_quantity) {
            /** @disregard */
            $fail('Insufficient stock available.');
        }
    }
}
