<?php

namespace App\Utils\Payment;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentDb
{
    public function savePayment(Request $request): Payment
    {
        $totalAmount = 0;

        $productIds = collect($request->products)->pluck('id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $bank = ['garanti', 'finansbank', 'hsbc'];

        foreach ($request->products as $productData) {
            if (isset($products[$productData['id']])) {
                $product = $products[$productData['id']];
                $totalAmount += $product->price * $productData['quantity'];
            }
        }

        $payment = new Payment();
        $payment->company_id = $request->user()->id;
        $payment->payment_id = rand(100000, 999999);
        $payment->amount = $totalAmount;
        $payment->currency = $request->currency;
        $payment->first_name = $request->firstName;
        $payment->last_name = $request->lastName;
        $payment->ip = $request->ip();
        $payment->test = $request->test ?? false;
        $payment->bank =  strtoupper($bank[array_rand($bank)]);

        $payment->save();

        foreach ($request->products as $productData) {
            if (isset($products[$productData['id']])) {
                $payment->products()->attach($products[$productData['id']], ['quantity' => $productData['quantity']]);
            }
        }
        return $payment;
    }

    public function listPayments(array $queryParams, int $companyId): \Illuminate\Pagination\LengthAwarePaginator
    {
        $startDate = $queryParams['startDate'] ?? null;
        $endDate = $queryParams['endDate'] ?? null;
        $status = $queryParams['status'] ?? null;

        $payments = Payment::query();

        $payments->where('company_id', $companyId);

        if ($startDate) {
            $payments->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $payments->where('created_at', '<=', $endDate);
        }

        if ($status) {
            $payments->where('status', $status);
        }


        return $payments->with('products')->paginate(10);;


    }
}
