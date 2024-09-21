<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->bigInteger('payment_id')->nullable();
            $table->bigInteger('transaction_id')->nullable();
            $table->decimal('amount',8,2);
            $table->string('currency');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('status',['PENDING','SUCCESS','FAILED'])->default('PENDING');
            $table->string('ip');
            $table->boolean('test')->default(false);
            $table->string('fail_reason')->nullable();
            $table->enum('bank', ['FINANSBANK', 'HSBC', 'GARANTI']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
