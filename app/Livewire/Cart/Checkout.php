<?php

namespace App\Livewire\Cart;

use App\DTO\Cart\CartDataDTO;
use App\DTO\Cart\CheckoutDTO;
use App\Enums\OrderDeliveryMethodType;
use App\Enums\OrderPaymentMethodType;
use App\Exceptions\ErrorCreatingOrder;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('app')]
class Checkout extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $address = '';
    public string $email = '';
    public string $phone = '';

    public OrderDeliveryMethodType $delivery_method = OrderDeliveryMethodType::Post;
    public OrderPaymentMethodType $payment_method = OrderPaymentMethodType::Online;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'min:3', 'max:255'],
            'last_name' => ['required', 'min:3', 'max:255'],
            'address' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'regex:/^(\+38)?(0\d{9})$/'],
            'delivery_method' => ['required', Rule::enum(OrderDeliveryMethodType::class)],
            'payment_method' => ['required', Rule::enum(OrderPaymentMethodType::class)],
        ];
    }

    public function mount(CartService $cartService)
    {
        if ($cartService->isEmpty()) {
            return $this->redirect(route('cart'));
        }
    }

    public function getCartDataProperty(CartService $cartService): CartDataDTO
    {
        return $cartService->getCartDataDTO();
    }

    public function submit(CartService $cartService, OrderService $orderService)
    {
        $validated = $this->validate();

        $cartDataDto = $cartService->getCartDataDTO();

        if (!$orderService->isAllProductsAvailable($cartDataDto)) {
            // If on checkout page someone else created order and stock is null
            return $this->redirect(route('cart'));
        }

        try {
            $orderService->checkout($cartDataDto, CheckoutDTO::from($validated));
        } catch (ErrorCreatingOrder $exception) {
            // If order was not created, we can return an error message about this
            return $this->redirect(route('cart'));
        }

        $cartService->clear();

        return $this->redirect(route('checkout.success'));
    }

    public function render()
    {
        return view('livewire.cart.checkout');
    }
} 