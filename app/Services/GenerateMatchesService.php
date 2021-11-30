<?php

namespace App\Services;

use App\Contracts\GenerateMatchesInterface;
use App\Support\Constants;
use Exception;

abstract class GenerateMatchesService implements GenerateMatchesInterface
{
    public int $teamCount;

    /**
     * Get generated matches
     *
     * @param array $weeks
     * @param array $strengths
     * @return array
     * @throws Exception
     */
    public function getPlayedMatches(array $weeks, array $strengths): array
    {
        $weeksCount = $this->teamCount * 2 - 2;
        $matchesCountPerWeek = $this->teamCount / 2;
        $matches = [];

        for ($week = 0; $week < $weeksCount; $week++) {
            for ($match = 0; $match < $matchesCountPerWeek; $match++) {
                $homeTeamId = array_shift($weeks[$week][$match]);
                $guestTeamId = array_shift($weeks[$week][$match]);
                $homeGoals = $this->calculateGoals($strengths[$homeTeamId] ?? null);
                $guestGoals = $this->calculateGoals($strengths[$guestTeamId] ?? null);
                $matches[] = [
                    'week' => $week + 1,
                    'home_team_id' => $homeTeamId,
                    'guest_team_id' => $guestTeamId,
                    'home_goals' => $homeGoals,
                    'guest_goals' => $guestGoals,
                    'home_pts' => $this->getPoints($homeGoals, $guestGoals),
                    'guest_pts' => $this->getPoints($guestGoals, $homeGoals),
                ];

            }
        }

        return $matches;
    }

    /**
     * Get points by the match
     *
     * @param int $first
     * @param int $second
     * @return int|void
     */
    public function getPoints(int $first, int $second): int
    {
        switch ($first <=> $second) {
            case 0:
                return 1;
            case -1:
                return 0;
            case 1:
                return 3;
        }
    }

    /**
     * Calculate goals according to team's strength
     *
     * @param int|null $strength
     * @return int
     * @throws Exception
     */
    protected function calculateGoals(?int $strength): int
    {
        switch ($strength) {
            case 1:
                return random_int(0, Constants::MAX_GOALS_PER_MATCH - $strength);
            case 2:
                return random_int(1, Constants::MAX_GOALS_PER_MATCH);
            case 3:
                return random_int(2, Constants::MAX_GOALS_PER_MATCH);
            default:
                return random_int(0, Constants::MAX_GOALS_PER_MATCH);
        }
    }
}
