<?php

namespace App\Models\enum;

// 靜態匯率表，只有 TWD, JPY, USD 三種貨幣
class CurrencyRate
{
    public const TWD = 'TWD';
    public const JPY = 'JPY';
    public const USD = 'USD';

    public static function getCurrencyRates()
    {
        return [
            self::TWD => [
                self::TWD => 1,
                self::JPY => 3.669,
                self::USD => 0.03281,
            ],
            self::JPY => [
                self::TWD => 0.26956,
                self::JPY => 1,
                self::USD => 0.00885,
            ],
            self::USD => [
                self::TWD => 30.444,
                self::JPY => 111.801,
                self::USD => 1,
            ],
        ];
    }
}
