<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeCasts([
            'low_stock_threshold' => 'integer',
        ]);
    }
}
