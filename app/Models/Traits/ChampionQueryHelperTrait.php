<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait ChampionQueryHelperTrait
{
    public static function getChampions()
    {
        return static::with('team')->orderBy('pos')->get();
    }

    public static function updateLeagueTable(array $teamId, array $data)
    {
        static::query()->updateOrCreate($teamId, $data);
    }

    public static function getSortedLeagueTable()
    {
        return static::query()
            ->orderByDesc('points')
            ->orderByDesc('gd')
            ->get();
    }

    public static function truncateTable()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(static::TABLE)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
