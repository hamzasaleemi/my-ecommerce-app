<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product_id = Product::inRandomOrder()->first()->id;
        $file = file_get_contents(config('app.url') . '/images/temp/' . fake()->numberBetween(1, 10) . '.jpg');
        $imageNumber = fake()->unique()->numberBetween(1, 1000);
        Storage::put('images/products/product_' . $product_id . '_image_' . $imageNumber . '.jpg', $file);
        return [
            'product_id' => $product_id,
            'image_path' => 'images/products/product_' . $product_id . '_image_' . $imageNumber . '.jpg',
        ];
    }


}
