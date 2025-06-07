<?php

namespace Tests\Unit\Services;

use App\DTO\Cart\CartDataDTO;
use App\DTO\Cart\CartItemDTO;
use App\DTO\Cart\CheckoutDTO;
use App\Enums\OrderDeliveryMethodType;
use App\Enums\OrderPaymentMethodType;
use App\Enums\OrderStatusType;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * @covers \App\Services\OrderService::checkout
     */
    public function testСheckout(): void
    {
        /** Preparing data */

        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 5
        ]);

        $cartItem = CartItemDTO::from([
            'product' => $product,
            'quantity' => 2
        ]);

        $cartData = CartDataDTO::from([
            'items' => [$cartItem]
        ]);

        // Prepare CheckoutDTO
        $checkoutData = CheckoutDTO::from([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'address' => '123 Test Street',
            'deliveryMethod' => OrderDeliveryMethodType::Post,
            'paymentMethod' => OrderPaymentMethodType::Online
        ]);

        /** Act */

        $order = $this->orderService->checkout($cartData, $checkoutData);

        /** Asserts */

        // Assert order was created correctly
        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(OrderStatusType::New, $order->status);
        $this->assertEquals('123 Test Street', $order->address);
        $this->assertEquals(OrderDeliveryMethodType::Post, $order->delivery_method);
        $this->assertEquals(OrderPaymentMethodType::Online, $order->payment_method);

        $this->assertInstanceOf(Customer::class, $order->customer);
        $this->assertEquals('John', $order->customer->first_name);
        $this->assertEquals('Doe', $order->customer->last_name);
        $this->assertEquals('john@example.com', $order->customer->email);
        $this->assertEquals('+1234567890', $order->customer->phone);

        // Assert order items were created correctly
        $this->assertCount(1, $order->orderItems);
        $orderItem = $order->orderItems->first();
        $this->assertEquals(2, $orderItem->amount);
        $this->assertEquals(100, $orderItem->product_price);
        $this->assertEquals($product->id, $orderItem->product_id);

        // Assert product stock was decremented
        $product->refresh();
        $this->assertEquals(3, $product->stock);
    }

    /**
     * @covers \App\Services\OrderService::isAllProductsAvailable
     */
    public function testIsAllProductsAvailable(): void
    {
        /** Preparing data */

        $product1 = Product::factory()->create(['stock' => 5]);
        $product2 = Product::factory()->create(['stock' => 2]);

        // Create cart items
        $cartItem1 = CartItemDTO::from([
            'product' => $product1,
            'quantity' => 3  // Available (5 in stock)
        ]);
        $cartItem2 = CartItemDTO::from([
            'product' => $product2,
            'quantity' => 3  // Not available (only 2 in stock)
        ]);

        /** Case only includes item with sufficient stock */

        $cartDataAvailable = CartDataDTO::from([
            'items' => [$cartItem1]
        ]);
        $this->assertTrue($this->orderService->isAllProductsAvailable($cartDataAvailable));

        /** Case when not all products are available */
        $cartDataNotAvailable = CartDataDTO::from([
            'items' => [$cartItem1, $cartItem2]  // Includes item with insufficient stock
        ]);
        $this->assertFalse($this->orderService->isAllProductsAvailable($cartDataNotAvailable));
    }
} 