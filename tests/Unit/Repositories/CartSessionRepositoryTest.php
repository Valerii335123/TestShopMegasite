<?php

namespace Tests\Unit\Repositories;

use App\DTO\Cart\CartDataDTO;
use App\DTO\Cart\CartItemDTO;
use App\Models\Product;
use App\Repositories\CartSessionRepository;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CartSessionRepositoryTest extends TestCase
{
    private CartSessionRepository $cartRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartRepository = new CartSessionRepository();
        Session::flush();
    }

    /**
     * @covers \App\Repositories\CartSessionRepository::get
     */
    public function testGet(): void
    {
        /** Preparing data */
        $product = Product::factory()->create();

        session()->put(CartSessionRepository::CART_KEY, [
            [
                'product_id' => $product->id,
                'quantity' => 2,
            ]
        ]);

        /** Act */

        $cart = $this->cartRepository->get();

        $this->assertInstanceOf(CartDataDTO::class, $cart);
        $this->assertCount(1, $cart->items);
        $this->assertEquals($product->id, $cart->items->first()->product->id);
        $this->assertEquals(2, $cart->items->first()->quantity);
    }

    /**
     * @covers \App\Repositories\CartSessionRepository::put
     */
    public function testPut(): void
    {
        /** Preparing data */
        $product = Product::factory()->create();

        $cartItem = CartItemDTO::from([
            'product' => $product,
            'quantity' => 2,
        ]);

        $cartData = CartDataDTO::from([
            'items' => collect([$cartItem])
        ]);

        $this->cartRepository->put($cartData);

        $sessionData = session()->get(CartSessionRepository::CART_KEY);

        $this->assertNotNull($sessionData);
        $this->assertEquals([$cartItem->toArray()], $sessionData);
    }

    /**
     * @covers \App\Repositories\CartSessionRepository::clear
     */
    public function testClear(): void
    {
        $product = Product::factory()->create();

        session()->put(CartSessionRepository::CART_KEY, [
            [
                'product_id' => $product->id,
                'quantity' => 2,
            ]
        ]);

        $this->assertNotNull(session()->get(CartSessionRepository::CART_KEY));

        $this->cartRepository->clear();

        $this->assertNull(session()->get(CartSessionRepository::CART_KEY));
    }
} 