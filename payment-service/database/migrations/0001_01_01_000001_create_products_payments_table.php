<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'payment-service-db';
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection($this->connection)->create('payment_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1); // Optional: Track quantity
            $table->timestamps();
            // Foreign keys
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('payment_products');
    }
};
