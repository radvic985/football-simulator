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
     * @return array
     * @throws Exception
     */
    public function getPlayedMatches(array $weeks): array
    {
        $weeksCount = $this->teamCount * 2 - 2;
        $matchesCountPerWeek = $this->teamCount / 2;
        $matches = [];

        for ($week = 0; $week < $weeksCount; $week++) {
            for ($match = 0; $match < $matchesCountPerWeek; $match++) {
                $homeGoals = random_int(0,Constants::MAX_GOALS_PER_MATCH);
                $guestGoals = random_int(0,Constants::MAX_GOALS_PER_MATCH);
                $matches[] = [
                    'week' => $week + 1,
                    'home_team_id' => array_shift($weeks[$week][$match]),
                    'guest_team_id' => array_shift($weeks[$week][$match]),
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
}
