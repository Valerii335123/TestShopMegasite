<?php

namespace App\Repositories;

use App\DTO\Cart\CartDataDTO;
use App\DTO\Cart\CartItemDTO;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartSessionRepository implements CartRepositoryInterface
{
    const CART_KEY = 'shopping_cart';

    /**
     * @return Collection<int, CartItemDTO>
     */
    public function get(): CartDataDTO
    {
        $raw = Session::get(self::CART_KEY, []);

        return CartDataDTO::from(
            [
                'items' => collect($raw)->map(
                    fn($item) => CartItemDTO::createFromSession($item)
                )
            ]
        );
    }

    public function put(CartDataDTO $cartDataDTO): void
    {
        Session::put(self::CART_KEY, $cartDataDTO->items->map(fn(CartItemDTO $item) => $item->toArray())->toArray());
    }

    public function clear(): void
    {
        Session::forget(self::CART_KEY);
    }
}
