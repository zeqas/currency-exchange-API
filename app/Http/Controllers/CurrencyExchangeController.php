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
        $source = $request->input('source');
        $target = $request->input('target');
        $amount = $request->input('amount');

        // TODO 驗證參數
        // source、target 為字串，amount 輸入時無論有無千分位皆可接受。例如「1,525」或「1525」皆可。

        // 呼叫 convert 方法
        $result = $this->currencyExchangeService->convert($source, $target, $amount);

        return $result;
    }
}
