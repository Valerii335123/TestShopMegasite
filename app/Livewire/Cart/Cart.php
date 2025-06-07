<?php

namespace App\Livewire\Cart;

use App\DTO\Cart\CartDataDTO;
use App\Models\Product;
use App\Services\CartService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('app')]
class Cart extends Component
{

    public function incrementQuantity(Product $product, CartService $cartService): void
    {
        $cartItem = $cartService->getCartDataDTO()->items->firstWhere('product.id', $product->id);

        if ($product->exists && $cartItem && $cartItem->quantity < $product->stock) {
            $cartService->updateQuantity($product, $cartItem->quantity + 1);
        }
    }

    public function decrementQuantity(Product $product, CartService $cartService): void
    {
        $cartItem = $cartService->getCartDataDTO()->items->firstWhere('product.id', $product->id);

        if ($product->exists && $cartItem && $cartItem->quantity > 1) {
            $cartService->updateQuantity($product, $cartItem->quantity - 1);
        }
    }

    public function removeItem(Product $product, CartService $cartService): void
    {
        $cartService->remove($product);
    }

    public function getCartDataProperty(CartService $cartService): CartDataDTO
    {
        return $cartService->getCartDataDTO();
    }

    public function render()
    {
        return view('livewire.cart.index');
    }
} 