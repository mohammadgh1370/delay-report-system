<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class OrderException extends BaseException
{
    public static function notFound()
    {
        throw new self('Order not found.', Response::HTTP_NOT_FOUND);
    }

    public static function deliveryTimeIsNotPast()
    {
        throw new self('Please wait, the delivery time is not yet finished.', Response::HTTP_BAD_REQUEST);
    }
}
