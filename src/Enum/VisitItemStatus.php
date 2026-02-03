<?php

namespace App\Enum;

enum VisitItemStatus: string
{
    case DRAFT = 'DRAFT';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
}