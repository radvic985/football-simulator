<?php

namespace App\Models\Traits;

use App\Models\Team;

trait TeamQueryHelperTrait
{
    public static function getTeamIdByName(string $name): ?int
    {
        /** @var Team $team */
        $team = static::query()->where('name', $name)->first();
        return $team->id ?? null;
    }

    public static function getTeamList(int $amount)
    {
        return static::query()->take($amount)->get();
    }
}
