<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('app')]
class Show extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $product->loadMedia('images');
        $this->product = $product;
    }

    public function addToCart(Product $product, CartService $cartService)
    {
        $cartService->add($product);
    }

    public function removeFromCart(Product $product, CartService $cartService)
    {
        $cartService->remove($product);
    }

    public function render(CartService $cartService)
    {
        return view('livewire.product.show', [
            'isSelected' => $cartService->isSelected($this->product),
        ]);
    }
} 