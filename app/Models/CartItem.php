<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * ---------------------------------------------------------------------
     * End Relationships
     * ---------------------------------------------------------------------
     */
}
