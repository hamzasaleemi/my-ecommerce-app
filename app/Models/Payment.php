<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeCasts([
            'order_id' => 'integer',
            'transaction_id' => 'string',
            'amount_paid' => 'decimal:2',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Relationships
     * ---------------------------------------------------------------------
     */

    /**
     * Get the order that owns the payment.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * ---------------------------------------------------------------------
     * End Relationships
     * ---------------------------------------------------------------------
     */
}
