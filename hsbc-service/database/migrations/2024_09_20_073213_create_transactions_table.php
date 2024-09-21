<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'hsbc-service-db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')->nullable();
            $table->decimal('amount',8,2);
            $table->string('currency');
            $table->enum('status',['PENDING','SUCCESS','FAILED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('transactions');
    }
};
