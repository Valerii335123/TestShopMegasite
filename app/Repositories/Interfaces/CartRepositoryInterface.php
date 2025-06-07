<?php

namespace App\Repositories\Interfaces;

use App\DTO\Cart\CartDataDTO;

interface CartRepositoryInterface
{

    public function get(): CartDataDTO;

    public function put(CartDataDTO $cartDataDTO): void;

    public function clear(): void;
}
