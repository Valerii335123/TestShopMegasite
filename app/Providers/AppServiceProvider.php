<?php

namespace App\Providers;

use App\Repositories\CartSessionRepository;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        CartRepositoryInterface::class => CartSessionRepository::class,
    ];

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
        //
    }
}
