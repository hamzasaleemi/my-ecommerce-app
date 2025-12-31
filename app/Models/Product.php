<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeCasts([
            'name' => 'string',
            'description' => 'string',
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Relationships
     * ---------------------------------------------------------------------
     */

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * ---------------------------------------------------------------------
     * End Relationships
     * ---------------------------------------------------------------------
     */
}
