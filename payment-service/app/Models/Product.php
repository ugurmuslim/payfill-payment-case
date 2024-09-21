<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $connection = 'payment-service-db';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'sku',
        'status',
    ];

    // Define the relation to Payment through the payment_products table
    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'payment_products')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
