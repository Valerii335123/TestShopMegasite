<?php

namespace App\Exceptions;

use Exception;

class ErrorCreatingOrder extends Exception
{
    protected $message = "Error creating order";
}
