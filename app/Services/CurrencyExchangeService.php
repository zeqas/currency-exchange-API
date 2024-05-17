<?php

namespace App\Services;

use App\Models\enum\CurrencyRate;

class CurrencyExchangeService
{
    private $currency_rates;

    // 注入 CurrencyRate
    public function __construct(CurrencyRate $currencyRate)
    {
        $this->currency_rates = $currencyRate->getCurrencyRates();
    }

    // 匯率轉換
    public function convert($source, $target, $amount)
    {
        // 如果 amount 中含有逗號，則移除逗號
        $amount = str_replace(',', '', $amount);

        $rawConvertedAmount = $amount * $this->currency_rates[$source][$target];
        // 四捨五入到小數點第二位
        $roundedConvertedAmount = round($rawConvertedAmount, 2);
        // 加上半形逗點作為千分位表示，每三個位數一點
        // ex. 1234567.89 -> 1,234,567.89
        $convertedAmount = number_format($roundedConvertedAmount, 2, '.', ',');

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
