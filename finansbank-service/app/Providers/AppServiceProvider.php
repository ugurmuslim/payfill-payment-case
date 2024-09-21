<?php

namespace App\Providers;

use App\Utils\Finansbank\BankCommunication;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(BankCommunication::class, function ($app) {
            return new BankCommunication([
                [
                    'success' => true,
                    'transactionID' => rand(100000, 999999),
                    'message' => '',
                    'status' => 'SUCCESS'
                ],
                [
                    'success' => true,
                    'transactionID' => rand(100000, 999999),
                    'message' => '',
                    'status' => 'PENDING'
                ],
                [
                    'success' => false,
                    'transactionID' => null,
                    'message' => 'Credentials are wrong',
                    'status' => 'FAILED'
                ],
            ]);
        });
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
