<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 *
 * @property int $company_id
 * @property int $payment_id
 * @property int|null $transaction_id
 * @property float $amount
 * @property string $currency
 * @property string $first_name
 * @property string|null $last_name
 * @property string $ip
 * @property bool $test
 * @property string $bank
 * @property string $fail_reason
 */
class Payment extends Model
{
    use HasFactory;

    protected $connection = 'payment-service-db';

    protected $fillable = [
        'company_id',
        'payment_id',
        'transaction_id',
        'amount',
        'currency',
        'first_name',
        'ip',
        'test',
        'bank',
        'fail_reason'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'payment_products')
            ->withPivot('quantity')
            ->withTimestamps();

    }
}
