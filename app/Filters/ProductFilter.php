<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends BaseFilter
{
    protected function filterSearch(Builder $query, string $value): void
    {
        $query->where(function (Builder $query) use ($value) {
            $query->where('name', 'like', "%$value%")
                ->orWhere('sku', 'like', "%$value%");
        });
    }
} 