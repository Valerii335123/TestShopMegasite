<?php

namespace App\Traits\Models\Scopes;

use App\Filters\BaseFilter;

trait Filterable
{
    public function scopeFilter($query, BaseFilter $filters)
    {
        return $filters->apply($query);
    }
}
