<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatusEnum extends Enum
{
    const  EMPTY = 1;
    const  ORDER_REQUESTED = 2;
    const  ORDER_APPROVED = 3;
    const  ORDER_PAID = 4;
    const  SHIP_REQUESTED = 5;
    const  SHIP_STATUS = 6;
    const  SHIP_FAILED = 7;
    const  SHIP_DONE = 8;
    const  ASSESSMENT = 9;
    const  RETURN_REQUESTED = 10;
    const  RETURN_CONFIRM = 11;
    const  RETURN_SHIPPING = 12;
    const  RETURN_FAILED = 13;
    const  RETURN_DONE = 14;
    const  TRANSACTION_FINISHED = 15;
    const  TRANSACTION_CANCELLED = 16;
    const  ORDER_REJECTED = 17;
}
