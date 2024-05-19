<?php

namespace Tests\Unit;

use App\Models\enum\CurrencyRate;
use Tests\TestCase;
use App\Services\CurrencyExchangeService;

class CurrencyExchangeServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $currencyRate = new CurrencyRate();
        $this->service = new CurrencyExchangeService($currencyRate);
    }

    // Source 不符合 TWD, JPY, USD 三種貨幣之一
    public function testInvalidSourceCurrency()
    {
        $response = $this->service->convert('RMB', 'USD', 100);
        $convertedAmount = $response->getData(true);
        $this->assertEquals('必須為有效的貨幣ISO代碼', $convertedAmount['message']);
    }

    // Target 不符合 TWD, JPY, USD 三種貨幣之一
    public function testInvalidTargetCurrency()
    {
        $response = $this->service->convert('USD', 'RMB', 100);
        $convertedAmount = $response->getData(true);
        $this->assertEquals('必須為有效的貨幣ISO代碼', $convertedAmount['message']);
    }

    // Amount 不是有效數字
    public function testInvalidAmount()
    {
        $response = $this->service->convert('USD', 'JPY', 'invalid_amount無效數字');
        $convertedAmount = $response->getData(true);
        $this->assertEquals('必須為有效數字', $convertedAmount['message']);
    }
}
