<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyExchangeService;

class CurrencyExchangeController extends Controller
{
    protected $currencyExchangeService;

    public function __construct(CurrencyExchangeService $currencyExchangeService)
    {
        $this->currencyExchangeService = $currencyExchangeService;
    }

    /**
     * 匯率轉換 API
     * 參數格式範例: ?source=USD&target=JPY&amount=1,525
     */

    public function convert(Request $request)
    {
        // 取得參數
        $source = (string) $request->input('source');
        $target = (string) $request->input('target');
        $amount = $request->input('amount');

        // 驗證參數

        // source、target 必須為 TWD, JPY, USD 三種貨幣之一
        if (!$this->currencyExchangeService->isValidCurrency($source) ||        !$this->currencyExchangeService->isValidCurrency($target)) {
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

        // 呼叫 convert 方法
        $convertedAmount = $this->currencyExchangeService->convert($source, $target, $amountWithoutCommas);

        return response()->json([
            "message" => "success",
            "amount" => $convertedAmount,
        ]);
    }
}
