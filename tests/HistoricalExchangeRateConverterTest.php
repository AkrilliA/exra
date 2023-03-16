<?php

use AkrilliA\ExRa\Exceptions\MissingHistoricalExchangeRateException;
use AkrilliA\ExRa\HistoricalExchangeRateConverter;
use Money\Currency;
use Money\Money;

test('can convert to base currency at specific date', function () {
    $converter = new HistoricalExchangeRateConverter(
        [
            '2023-03-16' => [
                'EUR' => 1.000000,
                'USD' => 1.054900,
            ],
        ],
        new Currency('EUR')
    );

    $value = $converter->convertToBaseCurrencyAt(new DateTime('2023-03-16'), Money::USD(1266));

    expect($value)->toEqual(Money::EUR(1200));
});

test('can convert to any existing currency at specific date', function () {
    $converter = new HistoricalExchangeRateConverter(
        [
            '2023-03-16' => [
                'EUR' => 1.000000,
                'USD' => 1.054900,
                'BRL' => 5.567200,
            ],
        ],
        new Currency('EUR')
    );

    $value = $converter->convertToCurrencyAt(new DateTime('2023-03-16'), Money::USD(1200), new Currency('BRL'));

    expect($value)->toEqual(Money::BRL(6335));
});

test('exception is thrown on missing historical exchange rate', function () {
    $converter = new HistoricalExchangeRateConverter(
        [
            '2023-03-16' => [
                'EUR' => 1.000000,
                'USD' => 1.054900,
            ],
        ],
        new Currency('EUR')
    );

    $converter->convertToCurrencyAt(new DateTime('2023-03-15'), Money::USD(1200), new Currency('BRL'));
})->throws(MissingHistoricalExchangeRateException::class);
