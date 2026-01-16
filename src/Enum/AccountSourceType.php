<?php

namespace App\Enum;

enum AccountSourceType: string
{
    case VISIT = 'VISIT';
    case MANUAL = 'MANUAL';
    case ADJUSTMENT = 'ADJUSTMENT';
}
