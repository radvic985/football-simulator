<?php

namespace App\Services;

use App\Support\Constants;

class GenerateAllTeamMatchesService extends GenerateMatchesService
{
    /**
     * Get a grid of matches by weeks
     *
     * @param int $teamCount
     * @return array
     */
    public function getMatchesGrid(int $teamCount): array
    {
        $this->teamCount = $teamCount;
        return Constants::MAP_COUNT_TO_GRID[$teamCount];
    }
}
