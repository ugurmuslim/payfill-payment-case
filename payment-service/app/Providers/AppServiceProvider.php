<?php

namespace App\Providers;

use App\Events\PaymentProcessed;
use App\Listeners\UpdatePaymentStatus;
use App\Utils\Banks\BankServiceDistributor;
use App\Utils\Banks\Finansbank;
use App\Utils\Banks\Garanti;
use App\Utils\Banks\HSBC;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BankServiceDistributor::class, function ($app) {
            return new BankServiceDistributor([
                'GARANTI' => new Garanti(),
                'FINANSBANK' => new Finansbank(),
                'HSBC' => new HSBC(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            PaymentProcessed::class,
            UpdatePaymentStatus::class,
        );
    }
}
