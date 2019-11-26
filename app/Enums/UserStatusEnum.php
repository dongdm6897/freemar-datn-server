<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserStatusEnum extends Enum
{
    const  INACTIVE = 1;
    const  ACTIVE = 2;
    const  SNS = 3;
    const  SIMPLE = 4;
    const  MEDIUM_WAITING_FOR_VERIFICATION = 5;
    const  MEDIUM = 6;
    const  HIGH_WAITING_FOR_VERIFICATION = 7;
    const  HIGH = 8;
    const  BLOCKED = 9;
}
