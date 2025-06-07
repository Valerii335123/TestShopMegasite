<?php

namespace Tests\Unit\Services;

use App\DTO\Cart\CartDataDTO;
use App\Models\Product;
use App\Repositories\CartSessionRepository;
use App\Services\CartService;
use Tests\TestCase;
use phpDocumentor\Reflection\Exception;

class CartServiceTest extends TestCase
{
    private CartService $cartService;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartService = app(CartService::class);

        $this->product = new Product();
        $this->product->id = 1;
        $this->product->stock = 10;

        $this->assertNull(session()->get(CartSessionRepository::CART_KEY));
    }

    /**
     * @covers \App\Services\CartService::add
     */
    public function testAdd(): void
    {
        $this->cartService->add($this->product, 2);

        $cart = $this->cartService->getCartDataDTO();
        $this->assertCount(1, $cart->items);
        $this->assertEquals(2, $cart->items->first()->quantity);
        $this->assertEquals($this->product->id, $cart->items->first()->product->id);
    }

    /**
     * @covers \App\Services\CartService::add
     */
    public function testAddThrowExceptionForExistingProduct(): void
    {
        $this->cartService->add($this->product, 2);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Product already exists in the cart.');

        $this->cartService->add($this->product, 3);
    }

    /**
     * @covers \App\Services\CartService::add
     * @covers \App\Services\CartService::getCartDataDTO
     */
    public function testAddLimitQuantityToProductStock(): void
    {
        $this->cartService->add($this->product, 15);

        $cart = $this->cartService->getCartDataDTO();
        $this->assertEquals(10, $cart->items->first()->quantity);
    }

    /**
     * @covers \App\Services\CartService::add
     * @covers \App\Services\CartService::clear
     */
    public function testClear(): void
    {
        $this->cartService->add($this->product, 2);

        $this->assertNotNull(session()->get(CartSessionRepository::CART_KEY));
        $this->cartService->clear();

        $this->assertNull(session()->get(CartSessionRepository::CART_KEY));
    }

    /**
     * @covers \App\Services\CartService::add
     * @covers \App\Services\CartService::updateQuantity
     * @covers \App\Services\CartService::getCartDataDTO
     */
    public function testUpdateQuantity(): void
    {
        $this->assertNull(session()->get(CartSessionRepository::CART_KEY));
        $this->cartService->add($this->product, 2);
        $this->cartService->updateQuantity($this->product, 5);

        $cart = $this->cartService->getCartDataDTO();
        $this->assertEquals(5, $cart->items->first()->quantity);
    }

    /**
     * @covers \App\Services\CartService::isSelected
     */
    public function testIsSelected(): void
    {
        $this->assertNull(session()->get(CartSessionRepository::CART_KEY));
        $this->cartService->add($this->product, 2);

        $this->assertTrue($this->cartService->isSelected($this->product));
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue($this->cartService->isEmpty());

        $this->cartService->add($this->product, 2);

        $this->assertFalse($this->cartService->isEmpty());
    }

    public function testGetCartDataDTO(): void
    {
        $this->cartService->clear();
        $cart = $this->cartService->getCartDataDTO();

        $this->assertInstanceOf(CartDataDTO::class, $cart);
        $this->assertTrue($cart->items->isEmpty());
    }
} 