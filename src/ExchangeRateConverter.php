<?php

namespace AkrilliA\ExRa;

use AkrilliA\ExRa\Exceptions\MissingExchangeRateException;
use Money\Currency;
use Money\Money;

final class ExchangeRateConverter
{
    /**
     * @param  array<string, float>  $exchangeRates
     */
    public function __construct(
        private readonly array $exchangeRates,
        private readonly Currency $baseCurrency
    ) {
    }

    public function convertToCurrency(Money $money, Currency $currency): Money
    {
        $exchangeRate = $this->getExchangeRate($currency);

        $base = $this->convertToBaseCurrency($money);

        return $this->newMoneyInstance($base->multiply($exchangeRate), $currency);
    }

    public function convertToBaseCurrency(Money $money): Money
    {
        $code = $money->getCurrency()->getCode();

        if ($code === $this->baseCurrency->getCode()) {
            return $money;
        }

        $exchangeRate = $this->getExchangeRate($money->getCurrency());

        return $this->newMoneyInstance($money->divide($exchangeRate), $this->baseCurrency);
    }

    public function getExchangeRate(Currency $currency): float
    {
        if (! array_key_exists($currency->getCode(), $this->exchangeRates)) {
            throw new MissingExchangeRateException($currency);
        }

        return $this->exchangeRates[$currency->getCode()];
    }

    private function newMoneyInstance(Money $money, Currency $currency): Money
    {
        return new Money($money->getAmount(), $currency);
    }
}
