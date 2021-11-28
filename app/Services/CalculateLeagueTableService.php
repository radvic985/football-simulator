<?php

namespace App\Services;

use App\Contracts\CalculateLeagueTableInterface;
use App\Models\Champion;
use App\Models\MatchResult;
use Illuminate\Database\Eloquent\Collection;

class CalculateLeagueTableService implements CalculateLeagueTableInterface
{
    /**
     * Calculate a league table
     *
     * @param int|null $week
     * @return void
     */
    public function calculateTable(?int $week): void
    {
        $week = $this->checkWeek($week);
        $results = MatchResult::getMatchResultsToWeek($week);

        $home = $results->groupBy('home_team_id');
        $guest = $results->groupBy('guest_team_id');

        $result = $this->mergeHomeAndGuestMatches($home, $guest);
        $data = $this->prepareDataForLeagueTable($result, $week);

        foreach ($data as $teamId => $fields) {
            Champion::updateLeagueTable(['team_id' => $teamId], $fields);
        }

        $league = Champion::getSortedLeagueTable();
        $league->map(function (Champion $champion, $key) {
            $champion->update(['pos' => $key + 1]);
        });
    }

    /**
     * Merge home and guest matches collection by team
     *
     * @param Collection $home
     * @param Collection $guest
     * @return Collection|\Illuminate\Support\Collection
     */
    private function mergeHomeAndGuestMatches(Collection $home, Collection $guest)
    {
        $result = $home->map(function ($item, $key) use (&$guest) {
            if ($guest->has($key)) {
                $item = $item->merge($guest[$key]);
                $guest->forget($key);
            }
            return $item;
        });

        if ($guest->isNotEmpty()) {
            $result = $result->union($guest);
        }

        return $result;
    }

    /**
     * Prepare data for update or insert to the league table
     *
     * @param Collection|\Illuminate\Support\Collection $result
     * @param int|null $week
     * @return array
     */
    private function prepareDataForLeagueTable($result, ?int $week): array
    {
        $league = Champion::getSortedLeagueTable();
        $data = [];
        $result->map(function (Collection $col, $key) use (&$data, $week, $league) {
            $homePoints = $col->where('home_team_id', $key)->sum('home_pts');
            $guestPoints = $col->where('guest_team_id', $key)->sum('guest_pts');
            $homeWon = $col->where('home_team_id', $key)->where('home_pts', '>', 1)->count();
            $guestWon = $col->where('guest_team_id', $key)->where('guest_pts', '>', 1)->count();
            $homeDrawn = $col->where('home_team_id', $key)->where('home_pts', '=', 1)->count();
            $guestDrawn = $col->where('guest_team_id', $key)->where('guest_pts', '=', 1)->count();
            $homeLost = $col->where('home_team_id', $key)->where('home_pts', '<', 1)->count();
            $guestLost = $col->where('guest_team_id', $key)->where('guest_pts', '<', 1)->count();
            $homeGF = $col->where('home_team_id', $key)->sum('home_goals');
            $guestGF = $col->where('guest_team_id', $key)->sum('guest_goals');
            $homeGA = $col->where('home_team_id', $key)->sum('guest_goals');
            $guestGA = $col->where('guest_team_id', $key)->sum('home_goals');
            /** @var Champion $previousPosition */
            $previousPosition = $league->where('team_id', $key)->first();

            $data[$key] = [
                'played' => $week,
                'won' => $homeWon + $guestWon,
                'drawn' => $homeDrawn + $guestDrawn,
                'lost' => $homeLost + $guestLost,
                'gf' => $homeGF + $guestGF,
                'ga' => $homeGA + $guestGA,
                'gd' => ($homeGF + $guestGF) - ($homeGA + $guestGA),
                'points' => $homePoints + $guestPoints,
                'prev_pos' => !empty($previousPosition) ? $previousPosition->pos : 0,
            ];
        });

        return $data;
    }

    private function checkWeek(?int $week): int
    {
        if ($week) return $week;

        return (int)MatchResult::getMaxWeek();
    }
}
