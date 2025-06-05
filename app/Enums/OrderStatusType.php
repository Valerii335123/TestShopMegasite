<?php

namespace App\Enums;

enum OrderStatusType: string
{
    case New = 'new';
    case Processing = 'processing';
    case Completed = 'completed';
}
