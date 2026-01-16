<?php

namespace App\Enum;

enum VisitStatus: string
{
    case OPEN = 'OPEN';
    case CLOSED = 'CLOSED';
    case CANCELLED = 'CANCELLED';
}
