<?php
namespace App\Enum;

enum AccountEntryType: string
{
    case CHARGE = 'CHARGE';         // + patient owes
    case PAYMENT = 'PAYMENT';       // - patient pays
    case EXPENSE = 'EXPENSE';       // - company spends
    case ADJUSTMENT = 'ADJUSTMENT'; // +/- correction
}
