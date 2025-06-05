<?php

namespace App\Enums;

enum OrderPaymentMethodType: string
{
    case Postpaid = 'postpaid';
    case Online = 'online';
}
