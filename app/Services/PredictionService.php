<?php

namespace App\Services;

use App\Contracts\PredictionInterface;
use App\Models\Champion;
use Illuminate\Support\Collection;

class PredictionService implements PredictionInterface
{
    /**
     * Get predictions for teams
     *
     * @return void
     */
    public function getPrediction(): Collection
    {
        $champion = Champion::getChampions();

        $teamCount = $champion->count();
        $leftGames = 2 * $teamCount - 2 - $champion->max('played');

        if ($leftGames === 0) {
            return $this->getFinalPrediction($champion);
        }

        $percents = $this->getIntermediatePercents($champion, $leftGames);
        $percentMax = $percents->max();

        $index = null;
        if ($percents->filter(fn($item) => $item !== $percentMax)->isEmpty()) {
            $index = 0;
        } elseif ($percents->filter(fn($item) => $item !== $percentMax)->count() === 1) {
            $index = 1;
        } elseif ($percents->filter(fn($item) => $item !== $percentMax)->count() === 2 &&
            $percents->filter(fn($item) => $item !== $percentMax && $item !== 0)->count() <= 0) {
            $index = 2;
        }

        if (!is_null($index)) {
            return $this->getPredictionForEqualsPercents($champion, $teamCount, $index);
        }

        $data = $this->calculatePercents($percents);

        $champion->transform(function (Champion $champion) use ($data) {
            $champion->percent = $data[$champion->team_id] ?? 0;
            return $champion;
        });

        return $champion;
    }

    /**
     * Get 100% result for correct team after the end of the championship
     * @param $champion
     * @return mixed
     */
    private function getFinalPrediction($champion)
    {
        $maxPoint = $champion->max('points');
        if ($champion->where('points', $maxPoint)->count() > 1) {
            $maxGD = $champion->where('points', $maxPoint)->max('gd');

            $champion->transform(function (Champion $champion) use ($maxPoint, $maxGD) {
                $champion->percent = 0;
                if ($champion->points === $maxPoint && $champion->gd === $maxGD) {
                    $champion->percent = 100;
                }
                return $champion;
            });
        } else {
            $champion->transform(function (Champion $champion) use ($maxPoint) {
                $champion->percent = 0;
                if ($champion->points === $maxPoint) {
                    $champion->percent = 100;
                }
                return $champion;
            });
        }

        return $champion;
    }

    /**
     * Get intermediate percents
     *
     * @param $champion
     * @param int $leftGames
     * @return mixed
     */
    private function getIntermediatePercents($champion, int $leftGames)
    {
        $points = $champion->pluck('points', 'team_id');
        $maxPoint = $points->max();

        return $points->map(function ($item) use ($maxPoint, $leftGames) {
            $percent = (int)round((100 * ($item - $maxPoint + 3 * $leftGames) / (3 * $leftGames)) / $leftGames);
            return $percent > 0 ? $percent : 0;
        });
    }

    /**
     * Get predictions for equals percents of different amounts of teams
     * @param $champion
     * @param $teamCount
     * @param $index
     * @return mixed
     */
    public function getPredictionForEqualsPercents($champion, $teamCount, $index)
    {
        $points = $champion->pluck('points', 'team_id');
        $maxPoint = $points->max();
        return $champion->transform(function (Champion $champion) use ($teamCount, $maxPoint, $index) {
            $champion->percent = 0;
            if ($champion->points === $maxPoint) {
                $champion->percent = floor(100 / ($teamCount - $index));
            }
            return $champion;
        });
    }

    /**
     * Calculate prediction percents for different cases
     *
     * @param Collection $percents
     * @return array
     */
    private function calculatePercents(Collection $percents): array
    {
        $percentMax = $percents->max();
        if ($percentMax === 100) {
            if ($percents->filter(fn($item) => $item === $percentMax)->count() > 1) {
                $percents->transform(function ($item) {
                    return floor($item / 2);
                });
                $percentMax = $percents->max();
                $secondSum = $percents->filter(fn($item) => $item !== $percents->max())->sum();
                $newPercentMax = floor((100 - $secondSum) / 2);

                $finalPercents = $percents->map(function ($item) use ($newPercentMax, $percentMax) {
                    if ($item === $percentMax) {
                        $item = $newPercentMax;
                    }
                    return $item;
                });
            } else {
                $percents->transform(function ($item) {
                    return floor($item / 2);
                });
                $newPercentSum = $percents->sum();
                $newPercentMax = $percents->max();

                $finalPercents = $percents->map(function ($item) use ($newPercentMax, $newPercentSum) {
                    if ($item === $newPercentMax) {
                        $item = 100 - $newPercentSum + $newPercentMax;
                    }
                    return $item;
                });
            }
        } else {
            $secondMax = $percents->filter(fn($item) => $item !== $percentMax)->max();
            $coefficient = abs(0.74 - ($secondMax / $percentMax - 0.74));

            $percents->transform(function ($item) use ($percentMax, $coefficient) {
                if ($item !== $percentMax) {
                    return round($item * $coefficient);
                }
                return $item;
            });

            $notMaxPercentsSum = $percents->filter(fn($item) => $item !== $percentMax)->sum();
            $forMaxPercentsValue = 100 - $notMaxPercentsSum;
            if ($percentMax === 50 && $percents->filter(fn($item) => $item === $percentMax)->count() > 1) {
                $forMaxPercentsValue = floor((100 - $notMaxPercentsSum) / 2);
            }

            $finalPercents = $percents->map(function ($item) use ($percentMax, $forMaxPercentsValue) {
                if ($item === $percentMax) {
                    $item = $forMaxPercentsValue;
                }
                return $item;
            });
        }

        return $finalPercents->toArray();
    }
}
