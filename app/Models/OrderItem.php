<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeCasts([
            'order_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer',
            'price_at_time_of_purchase' => 'decimal:2',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Relationships
     * ---------------------------------------------------------------------
     */

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that this order item refers to.
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
