<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{
    protected array $filters = [];

    public function apply(Builder $query): Builder
    {
        foreach ($this->filters as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            $method = 'filter' . str($key)->studly();

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
            }
        }

        return $query;
    }

    public function fromArray(array $data): static
    {
        $this->filters = $data;

        return $this;
    }

    protected function filterSort(Builder $query, string $value): void
    {
        if (empty($value)) {
            return;
        }

        $sort = 'asc';
        if ($value[0] === '-') {
            $sort = 'desc';
            $value = substr($value, 1);
        }

        $query->orderBy($value, $sort);
    }

}