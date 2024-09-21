<?php

namespace App\Utils\Banks;

use App\Utils\Interfaces\BankServiceInterface;
use App\Utils\Payment\PaymentRequest;
use Illuminate\Support\Facades\Http;

class Finansbank implements BankServiceInterface
{
    public function processPayment(PaymentRequest $request)
    {
        $response = Http::withHeaders($request->getHeaders())
            ->post(env('FINANSBANK_SERVICE_URL') . '/payment', [
            'amount' => $request->getAmount(),
            'cardNumber' => $request->getCardNumber(),
            'currency' => $request->getCurrency(),
            'ccv' => $request->getCcv(),
            'expiryDate' => $request->getExpiryDate(),
            'name' => $request->getName(),
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return ['error' => 'Payment failed', 'details' => $response->body()];
        }
    }
}
