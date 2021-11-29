<?php

namespace App\Providers;

use App\Contracts\PredictionInterface;
use App\Services\PredictionService;
use Illuminate\Support\ServiceProvider;

class PredictionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PredictionInterface::class, PredictionService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
