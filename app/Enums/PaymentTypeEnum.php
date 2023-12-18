<?php

namespace App\Enums;

class PaymentTypeEnum
{
    public const BUYCALL = 'BUYCALL';  // покупка звонков
    public const BUYSUB = 'BUYSUB';    // покупка подписки
    public const RENEWAL = 'RENEWAL';  // продление подписки
    public const TRIAL = 'TRIAL';      // пробный платеж (для смены карты)
}