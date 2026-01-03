<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class CartItem extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeCasts([
            'product_id' => 'integer',
            'user_id' => 'integer',
            'quantity' => 'integer',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Relationships
     * ---------------------------------------------------------------------
     */

    /**
     * Get the user for the cart item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for the cart item.
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

    /**
     * ---------------------------------------------------------------------
     * Scopes
     * ---------------------------------------------------------------------
     */

    protected function scopeWhereProduct(Builder $query, $productId): Builder
    {
        return $query->where('product_id', $productId);
    }

    protected function scopeWhereUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    protected function scopeItemsCount(Builder $query): Builder
    {
        return $query->selectRaw('SUM(quantity) as items_count');
    }

    /**
     * ---------------------------------------------------------------------
     * End Scopes
     * ---------------------------------------------------------------------
     */
}
