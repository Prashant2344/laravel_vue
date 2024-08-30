<?php

namespace App\Providers;

use App\Classes\CreditCardGateway;
use App\Classes\PaymentGateway;
use App\Interfaces\PaymentType;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(PaymentType::class, function($app){
            if(request()->has('credit')){
                return new CreditCardGateway('npr');
            }
            return new PaymentGateway('npr');
        });
    }
}
