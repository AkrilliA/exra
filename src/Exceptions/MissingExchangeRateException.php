<?php

namespace AkrilliA\ExRa\Exceptions;

use Money\Currency;

class MissingExchangeRateException extends \Exception
{
    public function __construct(Currency $currency)
    {
        parent::__construct("Missing exchange rate for currency {$currency->getCode()}.");
    }
}
