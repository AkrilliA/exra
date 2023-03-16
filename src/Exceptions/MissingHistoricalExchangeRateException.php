<?php

namespace AkrilliA\ExRa\Exceptions;

class MissingHistoricalExchangeRateException extends \Exception
{
    public function __construct(\DateTimeInterface $dateTime)
    {
        parent::__construct("Missing historical exchange rate for {$dateTime->format('Y-m-d')}.");
    }
}
