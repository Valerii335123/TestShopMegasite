<?php

namespace App\DTO\Cart;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;

class CartDataDTO extends Data
{
    /** @var Collection<int, CartItemDTO> */
    public Collection $items;

    public function getTotalPrice(): int
    {
        return $this->items->sum(fn($item) => $item->getTotalPrice());
    }
}