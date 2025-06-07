<?php

namespace App\Services;

use App\DTO\Cart\CartDataDTO;
use App\DTO\Cart\CartItemDTO;
use App\DTO\Cart\CheckoutDTO;
use App\Enums\OrderStatusType;
use App\Exceptions\ErrorCreatingOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use DB;

class OrderService
{
    public function checkout(CartDataDTO $cartDataDTO, CheckoutDTO $checkoutDTO): Order
    {
        try {
            return DB::transaction(function () use ($cartDataDTO, $checkoutDTO) {
                $customer = $this->createCustomer($checkoutDTO);
                $order = $this->createOrder($customer, $checkoutDTO);

                foreach ($cartDataDTO->items as $item) {
                    $this->createOrderItems($order, $item);
                    $this->reduceProductStock($item->product, $item->quantity);
                }

                return $order;
            });
        } catch (\Throwable $e) {
            Log::error('Checkout failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'cart_data' => $cartDataDTO,
                'checkout_data' => $checkoutDTO,
            ]);
            throw new ErrorCreatingOrder($e);
        }
    }

    public function isAllProductsAvailable(CartDataDTO $cartDataDTO): bool
    {
        return !$cartDataDTO->items
            ->map(fn(CartItemDTO $item) =>$item->isProductQuantityAvailable())
            ->contains(false);

    }

    private function createOrder(Customer $customer, CheckoutDTO $checkoutDTO): Order
    {
        $order = new Order([
            'status' => OrderStatusType::New,
            'address' => $checkoutDTO->address,
            'delivery_method' => $checkoutDTO->deliveryMethod,
            'payment_method' => $checkoutDTO->paymentMethod,
        ]);

        $order->customer()->associate($customer);
        $order->save();
        return $order;
    }

    private function createCustomer(CheckoutDTO $checkoutDTO): Customer
    {
        return Customer::createOrFirst(['phone' => $checkoutDTO->phone], [
            'first_name' => $checkoutDTO->firstName,
            'last_name' => $checkoutDTO->lastName,
            'email' => $checkoutDTO->email,
            'phone' => $checkoutDTO->phone,
        ]);
    }

    private function createOrderItems(Order $order, CartItemDTO $cartItemDTO): void
    {
        $orderItem = $order->orderItems()->make([
            'amount' => $cartItemDTO->quantity,
            'product_price' => $cartItemDTO->product->price,
        ]);
        $orderItem->product()->associate($cartItemDTO->product);
        $orderItem->save();
    }

    private function reduceProductStock(Product $product, int $quantity): void
    {
        $product->decrement('stock', $quantity);
        $product->save();
    }
}