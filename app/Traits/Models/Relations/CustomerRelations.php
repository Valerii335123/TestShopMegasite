<?php

namespace App\Traits\Models\Relations;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @mixin Customer */
trait CustomerRelations
{
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}