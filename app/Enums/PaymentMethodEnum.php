<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethodEnum extends Enum
{
    const BB_ACCOUNT = 1;
    const VNPAY = 2;
}
