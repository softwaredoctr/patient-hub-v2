<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CASH = 'CASH';
    case CARD = 'CARD';
    case TRANSFER = 'TRANSFER';
    case INSURANCE = 'INSURANCE';
}
