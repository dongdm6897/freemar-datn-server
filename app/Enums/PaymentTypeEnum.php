<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentTypeEnum extends Enum
{
    const BUYER_PAY = 1;
    const REFUND = 2;
    const PAY_FOR_SELLER = 3;
    const DEPOSIT = 4;
    const WITHDRAW = 5;
    const REQUEST_WITHDRAWAL = 6;
}
