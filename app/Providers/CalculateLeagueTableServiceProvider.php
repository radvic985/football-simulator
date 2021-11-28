<?php

namespace App\Providers;

use App\Contracts\CalculateLeagueTableInterface;
use App\Services\CalculateLeagueTableService;
use Illuminate\Support\ServiceProvider;

class CalculateLeagueTableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CalculateLeagueTableInterface::class, CalculateLeagueTableService::class);
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
