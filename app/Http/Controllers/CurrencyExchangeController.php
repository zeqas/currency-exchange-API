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

        // 呼叫 convert 方法
        try {
            $convertedAmount = $this->currencyExchangeService->convert($source, $target, $amount);

            return response()->json([
                "message" => "success",
                "amount" => $convertedAmount,
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 400);
        }
    }
}
