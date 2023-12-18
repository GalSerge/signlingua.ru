<?php

namespace App\Enums;

class PaymentStatusEnum
{
    public const PENDING = 'PENDING';
    public const WAITING = 'WAITING';
    public const SUCCEEDED = 'SUCCEEDED';
    public const CANCELED = 'CANCELED';
    public const REFUNDED = 'REFUNDED';
    public const CANCELED_REFUND = 'CANCELED_REFUND';
}