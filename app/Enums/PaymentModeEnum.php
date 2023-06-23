<?php

namespace App\Enums;

enum PaymentModeEnum: string {
    case CREDIT = 'CREDIT';
    case CASH = 'CASH';
    case MOMO = 'MOMO';
}
