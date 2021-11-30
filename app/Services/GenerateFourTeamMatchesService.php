<?php

namespace App\Services;

class GenerateFourTeamMatchesService extends GenerateMatchesService
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

        $weeks = [];
        $combinationsCollection = collect($this->getCombinations())->shuffle();
        $weeksCount = $this->teamCount * 2 - 2;

        for ($week = 0; $week < $weeksCount; $week++) {
            list($home, $guest) = $combinationsCollection->shift();
            $data = $combinationsCollection
                ->map(function ($item, $key) use ($home, $guest) {
                    if (!in_array($home, $item) && !in_array($guest, $item))
                        return [$key => $item];
                })
                ->filter()
                ->first();

            foreach ($data as $key => $value) {
                $combinationsCollection->forget($key);
                $weeks[$week] = [
                    [$home, $guest],
                    $value
                ];
            }
        }

        return $weeks;
    }

    /**
     * Get all possible combinations of teams including home and guest matches
     *
     * @return array
     */
    private function getCombinations(): array
    {
        $combinations = [];
        for ($i = 1; $i <= $this->teamCount; $i++) {
            for ($j = $i + 1; $j <= $this->teamCount; $j++) {
                $combinations[] = [$i, $j];
            }
            for ($j = $this->teamCount; $j >= $i + 1; $j--) {
                $combinations[] = [$j, $i];
            }
        }

        return $combinations;
    }
}
