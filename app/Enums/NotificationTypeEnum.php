<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationTypeEnum extends Enum
{
    const PRODUCT_COMMENT = 1;
    const ORDER_CHAT = 2;
    const ORDER = 3;
    const SYSTEM = 4;
}
