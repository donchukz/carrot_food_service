<?php

namespace App\Enums;

enum UserTypeEnum: string {
    case CUSTOMER = 'CUSTOMER';
    case BUSINESS_OWNER = 'BUSINESS_OWNER';
    case SUPPLIER = 'SUPPLIER';
}
