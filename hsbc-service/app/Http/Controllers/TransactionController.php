<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Utils\HSBC\BankCommunication;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    protected BankCommunication $bankCommunication;

    public function __construct(BankCommunication $bankCommunication)
    {
        $this->bankCommunication = $bankCommunication;
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'cardNumber' => 'required|string',
            'name' => 'required|string',
            'ccv' => 'required|numeric',
            'expiryDate' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 'FAILED'
            ], 422);
        }

        // Map the request to the format that the bank expects
        $requestBody = Utils::mapper($request);

        Log::info('Sending payment request to HSBC Bank', $requestBody);

        $response = $this->bankCommunication->processPayment($requestBody);

        Log::info('Received response from HSBC Bank', $response);

        Transaction::create([
            'transaction_id' => $response['transactionID'],
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $response['status']
        ]);

        $mappedResponse = Utils::responseMapper($response);

        return response()->json($mappedResponse);
    }
}
