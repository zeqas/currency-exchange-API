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
        // 驗證參數

        // source、target 必須為 TWD, JPY, USD 三種貨幣之一
        if (!$this->isValidCurrency($source) || !$this->isValidCurrency($target)) {
            return response()->json([
                "message" => "必須為有效的貨幣ISO代碼",
            ]);
        }

        // amount 輸入時無論有無千分位皆可接受。例如「1,525」或「1525」皆可。
        $amountWithoutCommas = str_replace(',', '', $amount);

        if (!is_numeric($amountWithoutCommas)) {
            return response()->json([
                "message" => "必須為有效數字",
            ]);
        }

        // 將 amount 四捨五入到小數點第二位再進行轉換
        $roundedAmount = round($amountWithoutCommas, 2);

        $targetRate = $this->currency_rates[$source][$target];

        // 先用 bcmul 避免浮點數計算誤差
        // FIXME 發現用 bcmul 也無法處理精度問題
        $rawConvertedAmount = bcmul((string) $roundedAmount, (string) $targetRate, 4);

        // 將 convertedAmount 四捨五入到小數點第二位
        // ex. 1.0945 -> 109.45 -> 109.5 -> 1.095
        $ceiledAmount = ceil($rawConvertedAmount * 100) / 100;

        $roundedConvertedAmount = round($ceiledAmount, 2);

        // 加上半形逗點作為千分位表示，每三個位數一點
        // ex. 1234567.89 -> 1,234,567.89
        $convertedAmount = number_format($roundedConvertedAmount, 2, '.', ',');

        return $convertedAmount;
    }

    // 驗證貨幣代碼是否有效
    public function isValidCurrency($currency)
    {
        return array_key_exists($currency, $this->currency_rates);
    }
}
