# **Ex**change **Ra**te Converter
ExRa is a simple package for converting exchange rates.

## Installation

Installing ExRa is as simple as installing any other package, just run `composer require akrillia/exra`

## Usage

There are two classes `ExchangeRateConverter` and `HistoricalExchangeRateConverter`. Use the converter 
which fits your needs better.

### ExchangeRateConverter

To create a new instance you must pass an array with currencies as keys and exchange rates as values. 
Also, you need to specify your base currency which the exchange rates refer. 
```php
$converter = new ExchangeRateConverter([
    'EUR' => 1.0,
    'USD' => 1.054900,
    'BRL' => 5.567200,
], new Currency('EUR'));
```

You can convert to the base currency:
```php
$money = $converter->convertToBaseCurrency(Money::USD(1200))
```

Or to any existing currency inside your exchange rate array:
```php
$money = $converter->convertToCurrency(Money::USD(1200), new Currency('BRL'));
```

Also, it is possible to get only the exchange rate for a currency:
```php
$rate = $converter->getExchangeRate(new Currency('USD'));
```

If no exchange rate is found for the given currency a `MissingExchangeRateException` will be thrown.

### HistoricalExchangeRateConverter

Like for the `ExchangeRateConverter` you need to pass an array and a base currency to create a new instance. The
exchange rate array must be wrapped inside an array with dates (`Y-m-d`) as keys.
```php
$converter = new ExchangeRateConverter([
    // ...
    '2023-03-16' => [
        'EUR' => 1.0,
        'USD' => 1.054900,
        'BRL' => 5.567200,
    ],
    // ...
], new Currency('EUR'));
```

You can convert to the base currency at a specific date:
```php
$money = $converter->convertToBaseCurrencyAt(new DateTime('2023-03-16'), Money::USD(1200))
```

Or to any existing currency inside your exchange rate array at a specific date:
```php
$money = $converter->convertToCurrencyAt(new DateTime('2023-03-16'), Money::USD(1200), new Currency('BRL'));
```

Also, it is possible to get only the exchange rate for a currency at a specific date:
```php
$rate = $converter->getExchangeRate(new DateTime('2023-03-16'), new Currency('USD'));
```

If no historical exchange rate is found for the given date a `MissingHistoricalExchangeRateException` will be thrown.
