<?php

namespace App\Utils\Interfaces;

use App\Utils\Payment\PaymentRequest;

interface BankServiceInterface
{
    public function processPayment(PaymentRequest $request);
}
