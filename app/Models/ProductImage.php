<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeCasts([
            'product_id' => 'integer',
            'image_path' => 'string',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Relationships
     * ---------------------------------------------------------------------
     */

    /**
     * Get the product for the product image.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ---------------------------------------------------------------------
     * End Relationships
     * ---------------------------------------------------------------------
     */
}
