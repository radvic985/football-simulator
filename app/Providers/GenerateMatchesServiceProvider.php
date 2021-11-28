<?php

namespace App\Providers;

use App\Contracts\GenerateMatchesInterface;
use App\Services\GenerateAllTeamMatchesService;
use App\Services\GenerateFourTeamMatchesService;
use App\Support\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class GenerateMatchesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->call([$this, 'registerMyService']);
    }

    public function registerMyService(Request $request)
    {
        $className = (int)$request->get('team_count') !== Constants::TEAMS_4 ?
            GenerateAllTeamMatchesService::class : GenerateFourTeamMatchesService::class;

        $this->app->bind(GenerateMatchesInterface::class, $className);
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
