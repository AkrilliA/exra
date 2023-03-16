<?php

namespace AkrilliA\ExRa;

use Akrillia\ExRa\Exceptions\MissingHistoricalExchangeRateException;
use Money\Currency;
use Money\Money;

final class HistoricalExchangeRateConverter
{
    /**
     * @param  array<string, array<string, float>>  $exchangeRates
     */
    public function __construct(
        private readonly array $exchangeRates,
        private readonly Currency $baseCurrency
    ) {
    }

    public function convertToCurrencyAt(\DateTimeInterface $dateTime, Money $money, Currency $currency): Money
    {
        $converter = $this->getConverterFor($dateTime);

        return $converter->convertToCurrency($money, $currency);
    }

    public function convertToBaseCurrencyAt(\DateTimeInterface $dateTime, Money $money): Money
    {
        $converter = $this->getConverterFor($dateTime);

        return $converter->convertToBaseCurrency($money);
    }

    public function getExchangeRateAt(\DateTimeInterface $dateTime, Currency $currency): float
    {
        $converter = $this->getConverterFor($dateTime);

        return $converter->getExchangeRate($currency);
    }

    public function getConverterFor(\DateTimeInterface $dateTime): ExchangeRateConverter
    {
        $format = $dateTime->format('Y-m-d');

        if (! array_key_exists($format, $this->exchangeRates)) {
            throw new MissingHistoricalExchangeRateException($dateTime);
        }

        $exchangeRateConverter = new ExchangeRateConverter(
            $this->exchangeRates[$format],
            $this->baseCurrency
        );

        return $exchangeRateConverter;
    }
}
