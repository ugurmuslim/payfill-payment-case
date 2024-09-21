<?php

namespace App\Utils\Banks;


use App\Utils\Interfaces\BankServiceInterface;
use App\Utils\Payment\PaymentRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HSBC implements BankServiceInterface
{
    public function processPayment(PaymentRequest $request)
    {
        Log::info('Processing payment with HSBC bank');
        $response = Http::withHeaders($request->getHeaders())
            ->post(env('HSBC_SERVICE_URL') . '/payment', [
            'amount' => $request->getAmount(),
            'cardNumber' => $request->getCardNumber(),
            'currency' => $request->getCurrency(),
            'ccv' => $request->getCcv(),
            'expiryDate' => $request->getExpiryDate(),
            'name' => $request->getName(),
        ]);
        Log::info('HSBC bank response: ' . $response->body());

        if ($response->successful()) {
            return $response->json();
        } else {
            return ['error' => 'Payment failed', 'details' => $response->body()];
        }
    }
}
