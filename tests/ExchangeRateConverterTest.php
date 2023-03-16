<?php

use AkrilliA\ExRa\Exceptions\MissingExchangeRateException;
use AkrilliA\ExRa\ExchangeRateConverter;
use Money\Currency;
use Money\Money;

test('can convert to base currency', function () {
    $converter = new ExchangeRateConverter(
        [
            'EUR' => 1.000000,
            'USD' => 1.054900,
        ],
        new Currency('EUR')
    );

    $value = $converter->convertToBaseCurrency(Money::USD(1266));

    expect($value)->toEqual(Money::EUR(1200));
});

test('can convert to any existing currency', function () {
    $converter = new ExchangeRateConverter(
        [
            'EUR' => 1.000000,
            'USD' => 1.054900,
            'BRL' => 5.567200,
        ],
        new Currency('EUR')
    );

    $value = $converter->convertToCurrency(Money::USD(1200), new Currency('BRL'));

    expect($value)->toEqual(Money::BRL(6335));
});

test('exception is thrown on missing exchange rate', function () {
    $converter = new ExchangeRateConverter(
        [
            'EUR' => 1.000000,
            'USD' => 1.054900,
        ],
        new Currency('EUR')
    );

    $converter->convertToCurrency(Money::USD(1200), new Currency('BRL'));
})->throws(MissingExchangeRateException::class);
