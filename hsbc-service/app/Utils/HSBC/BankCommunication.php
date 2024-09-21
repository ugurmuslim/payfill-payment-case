<?php

namespace App\Utils\HSBC;

class BankCommunication
{
    protected $possibleResponses = [];

    public function __construct(array $possibleResponses)
    {
        $this->possibleResponses = $possibleResponses;
    }

    public function processPayment($request)
    {
        return $this->possibleResponses[rand(0, 2)];
    }
}

