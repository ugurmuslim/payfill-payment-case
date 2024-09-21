<?php
namespace App\Utils;

class Utils
{
    public static function mapper($request): array
    {
        return [
            'price' => $request->amount,
            'cardNumber' => $request->cardNumber,
            'ame' => $request->name,
            'ccvNo' => $request->ccv,
            'expiry' => $request->expiryDate,
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
