<?php

namespace App\Enums;

enum OrderStatusEnum: string {
    case ACTIVE = 'ACTIVE';
    case CANCELLED = 'CANCELLED';
}
