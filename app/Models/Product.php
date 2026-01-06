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
     * Get the cart items for the product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the product images for the product.
     */
    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * ---------------------------------------------------------------------
     * End Relationships
     * ---------------------------------------------------------------------
     */

    public function scopeWithCartQuantity($query, $userId)
    {
        return $query->select('products.*')
            ->selectRaw('
                (SELECT quantity FROM cart_items WHERE cart_items.product_id = products.id AND cart_items.user_id = ?) AS cart_quantity
            ', [$userId]
            );
    }
}
