<?php

namespace App\Enums;

enum OrderDeliveryMethodType: string
{
    case Pickup = 'pickup';
    case Post = 'post';
}
