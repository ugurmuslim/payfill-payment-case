<?php
namespace App\Utils;

class Utils
{
    public static function mapper($request): array
    {
        return [
            'price' => $request->amount,
            'cardHolderNumber' => $request->cardNumber,
            'cardHolderName' => $request->name,
            'ccv' => $request->ccv,
            'expiryDate' => $request->expiryDate,
        ];
    }

    public static function responseMapper($response): array
    {
        return [
            'success' => $response['success'],
            'transactionID' => $response['transactionID'],
            'message' => $response['message'],
            'status' => $response['status']
        ];
    }
}
