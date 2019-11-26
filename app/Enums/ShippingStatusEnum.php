<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShippingStatusEnum extends Enum
{
    const PENDING = 1;
    const PICK_UP = 2;
    const PICKED_UP = 3;
    const DELIVERING = 4;
    const DELIVERED = 5;
    const PICKUP_FAILED = 6;
    const DELIVER_FAILED = 7;
}
