<?php

namespace App\Enum;

enum AccountEntryType: string
{
    case CHARGE = 'CHARGE';
    case PAYMENT = 'PAYMENT';
    case ADJUSTMENT = 'ADJUSTMENT';
}
