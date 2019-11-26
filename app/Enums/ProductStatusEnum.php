<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProductStatusEnum extends Enum
{
    const  NEW = 1;
    const  NEW_UNBOXED = 2;
    const  UNUSED = 3;
    const  NO_NOTICEABLE_DIRTY = 4;
    const  SLIGHTLY_DIRTY = 5;
    const  DIRTY = 6;
    const  OVERALL_BAD = 7;
}
