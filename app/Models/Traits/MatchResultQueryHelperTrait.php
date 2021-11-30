<?php

namespace App\Models\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait MatchResultQueryHelperTrait
{
    public static function getMatchResults(?int $week)
    {
        return static::with(['homeTeam', 'guestTeam'])
            ->when($week, function (Builder $query, $week) {
                return $query->where('week', $week);
            })
            ->orderBy('week')
            ->get();
    }

    public static function getMatchResultsToWeek(?int $week)
    {
        return static::query()
            ->when($week, function (Builder $query, $week) {
                return $query->where('week', '<=', $week);
            }, function (Builder $query) {
                return $query->orderBy('week');
            })
            ->get();
    }

    public static function updateMatchResult(array $where, array $data): int
    {
        return static::query()
            ->where('week', $where['week'])
            ->where('home_team_id', Team::getTeamIdByName($where['home_name']))
            ->update($data);
    }

    public static function saveMatches(array $matches)
    {
        static::truncateTable();
        static::query()->insert($matches);
    }

    public static function getMaxWeek()
    {
        return static::query()->max('week');
    }

    private static function truncateTable()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(static::TABLE)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
