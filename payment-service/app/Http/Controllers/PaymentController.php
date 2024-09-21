<?php

namespace App\Http\Controllers;

use App\Events\PaymentProcessed;
use App\Models\Product;
use App\Utils\Banks\BankServiceDistributor;
use App\Utils\Payment\PaymentDb;
use App\Utils\Payment\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    protected BankServiceDistributor $distributor;

    public function __construct(BankServiceDistributor $distributor)
    {
        $this->distributor = $distributor;
    }

    public function makePayment(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 'FAILED'
            ], 422);
        }

        Log::info('Starting payment process');
        $paymentDb = new PaymentDb();
        $payment = $paymentDb->savePayment($request);

        $paymentRequest = $this->createPaymentRequest($request, $payment->amount);
        $response = $this->distributor->distributePayment($paymentRequest, $payment->bank);

        PaymentProcessed::dispatch($payment, $response);

        return response()->json(['message' => $response]);
    }

    private function createPaymentRequest(Request $request, float $amount): PaymentRequest
    {


        $paymentRequest = new PaymentRequest();
        $paymentRequest
            ->setAmount($amount)
            ->setCardNumber($request->cardNumber)
            ->setCurrency($request->currency)
            ->setCcv($request->ccv)
            ->setExpiryDate($request->expiryDate)
            ->setName($request->name)
            ->setHeaders($request->headers->all());

        return $paymentRequest;
    }

    public function listPayments(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'date|nullable',
            'endDate' => 'date|nullable',
            'status' => 'in:PENDING,SUCCESS,FAILED|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 'FAILED'
            ], 422);
        }

        $queryParams = $request->query();

        $companyID = $request->user()->id;
        $paymentDb = new PaymentDb();
        $payments = $paymentDb->listPayments($queryParams, $companyID);
        return response()->json($payments);
    }
}
