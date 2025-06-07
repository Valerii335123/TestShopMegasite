<?php

namespace App\DTO\Cart;

use App\Models\Product;
use Spatie\LaravelData\Data;

class CartItemDTO extends Data
{
    public Product $product;
    public int $quantity;

    public function getTotalPrice(): int
    {
        return $this->quantity * $this->product->price;
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
        ];
    }

    public static function createFromSession(array $data): self
    {
        return self::from([
            'product' => Product::findOrFail($data['product_id']),
            'quantity' => $data['quantity'],
        ]);
    }
}