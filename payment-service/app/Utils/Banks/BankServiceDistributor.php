<?php

namespace App\Utils\Banks;

use App\Utils\Payment\PaymentRequest;

class BankServiceDistributor
{
    protected $bankServices = [];

    public function __construct(array $bankServices)
    {
        $this->bankServices = $bankServices;
    }

    public function distributePayment(PaymentRequest $request, string $bank)
    {
        $bankService = $this->bankServices[$bank];

        return $bankService->processPayment($request);
    }
}
