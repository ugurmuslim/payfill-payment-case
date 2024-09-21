<?php

namespace App\Listeners;

use App\Events\PaymentProcessed;

class UpdatePaymentStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentProcessed $event): void
    {
        $payment = $event->payment;
        $response = $event->response;

        $payment->transaction_id = $response['transactionID'] ?? null;
        $payment->status = $response['status'] ?? 'pending';
        $payment->fail_reason = $response['message'] ? '' : null;
        $payment->save();
    }
}
