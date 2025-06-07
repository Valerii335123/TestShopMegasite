<?php

namespace App\Services;

use App\DTO\Cart\CartDataDTO;
use App\DTO\Cart\CartItemDTO;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use phpDocumentor\Reflection\Exception;

class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $repository
    ) {
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $cart = $this->repository->get();

        $existingItem = $cart->items->firstWhere('product.id', $product->id);
        if ($existingItem) {
            throw new Exception('Product already exists in the cart.');
        }

        $quantity = min($quantity, $product->stock);
        $cart->items->push(CartItemDTO::from(['product' => $product, 'quantity' => $quantity]));

        $this->repository->put($cart);
    }

    public function clear(): void
    {
        $this->repository->clear();
    }

    public function remove(Product $product): void
    {
        $cart = $this->repository->get();
        $cart->items = $cart->items->reject(fn($item) => $item->product->id === $product->id);
        $this->repository->put($cart);
    }

    public function updateQuantity(Product $product, int $quantity): void
    {
        $cart = $this->repository->get();
        $cart->items = $cart->items->map(function (CartItemDTO $item) use ($product, $quantity) {
            if ($item->product->id === $product->id) {
                return CartItemDTO::from(['product' => $product, 'quantity' => $quantity]);
            }
            return $item;
        });

        $this->repository->put($cart);
    }

    public function isSelected(Product $product): bool
    {
        return $this->repository->get()->items->contains(fn($item) => $item->product->id === $product->id);
    }

    public function isEmpty(): bool
    {
        return $this->repository->get()->items->isEmpty();
    }

    public function getCartDataDTO(): CartDataDTO
    {
        return $this->repository->get();
    }
}
