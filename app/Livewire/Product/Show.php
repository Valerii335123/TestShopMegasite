<?php

namespace App\Livewire\Product;

use App\Models\Product;
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

    public function addToCart()
    {
        //
    }

    public function render()
    {
        return view('livewire.product.show');
    }
} 