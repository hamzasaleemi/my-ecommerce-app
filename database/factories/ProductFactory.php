<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $descriptions = [
            'This is a detailed product description that highlights the
            features, benefits, and specifications of this item. Here
            you\'ll find all the information needed to make an informed
            purchasing decision.',

            'This product description provides complete details about
            the item\'s features, specifications, and benefits. It covers
            everything from materials and dimensions to usage instructions
            and care guidelines to help customers understand exactly what
            they\'re purchasing.',

            'Discover the exceptional qualities of this product through our
            detailed description. We outline all key features, performance
            characteristics, and practical applications to demonstrate how this
            item meets your needs and exceeds expectations.',

            'This comprehensive description explains how our product solves
            problems and enhances your experience. We detail the craftsmanship,
            functionality, and unique advantages that make this item a valuable
            addition to your collection.',

            'A thorough overview of this product including its primary functions,
            technical specifications, material composition, and recommended uses.
            This description aims to provide transparent information to assist in
            your selection process.',

            'Complete product documentation covering dimensions, weight, materials,
            assembly requirements (if any), maintenance guidelines, and warranty
            information. This description serves as your complete reference guide
            for this item.'
        ];

        return [
            'name' => 'Product ' . fake()->unique()->numberBetween(0, 1000000),
            'description' => $descriptions[array_rand($descriptions)],
            'price' => fake()->randomFloat(2, 1, 10000),
            'stock_quantity' => fake()->numberBetween(0, 1000),
        ];
    }


}
