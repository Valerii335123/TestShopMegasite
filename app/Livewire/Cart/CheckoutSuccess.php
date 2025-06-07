<?php

namespace App\Livewire\Cart;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('app')]
class CheckoutSuccess extends Component
{
    public function render()
    {
        return view('livewire.cart.checkout-success');
    }
} 