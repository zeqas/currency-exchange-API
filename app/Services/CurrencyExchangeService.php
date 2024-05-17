<?php

namespace App\Services;

class CurrencyExchangeService
{
    private $currency_rates;

    // 靜態匯率表，只有 TWD, JPY, USD 三種貨幣
    public function __construct()
    {
        $this->currency_rates = [
            'TWD' => [
                'TWD' => 1,
                'JPY' => 3.669,
                'USD' => 0.03281,
            ],
            'JPY' => [
                'TWD' => 0.26956,
                'JPY' => 1,
                'USD' => 0.00885,
            ],
            'USD' => [
                'TWD' => 30.444,
                'JPY' => 111.801,
                'USD' => 1,
            ],
        ];
    }

    // 匯率轉換
    public function convert($source, $target, $amount)
    {
        // TODO 條件ㄧ: 四捨五入到小數點第二位
        // TODO 條件二: 加上半形逗點作為千分位表示，每三個位數一點

        // 如果 amount 中含有逗號，則移除逗號
        $amount = str_replace(',', '', $amount);
        $convertedAmount = $amount * $this->currency_rates[$source][$target];
        return $convertedAmount;
    }

    // TODO 測試案例
    /*
     *  CurrencyExchangeService 必須包含（但不限於）以下測試案例：
     *  1. 若輸入的 source 或 target 系統並不提供時的案例
     *  2. 若輸入的金額為非數字或無法辨認時的案例
     *  3. 輸入的數字需四捨五入到小數點第二位，並請提供覆蓋有小數與沒有小數的多種案例
    */
}
