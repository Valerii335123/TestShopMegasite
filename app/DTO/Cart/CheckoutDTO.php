<?php

namespace App\DTO\Cart;

use App\Enums\OrderDeliveryMethodType;
use App\Enums\OrderPaymentMethodType;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

class CheckoutDTO extends Data
{
    #[MapInputName(SnakeCaseMapper::class)]
    public string $firstName;
    #[MapInputName(SnakeCaseMapper::class)]
    public string $lastName;
    public string $email;
    public string $phone;
    public string $address;
    #[MapInputName(SnakeCaseMapper::class)]
    public OrderDeliveryMethodType $deliveryMethod;
    #[MapInputName(SnakeCaseMapper::class)]
    public OrderPaymentMethodType $paymentMethod;


}