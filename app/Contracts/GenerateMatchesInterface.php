<?php

namespace App\Contracts;

interface GenerateMatchesInterface
{
    public function getMatchesGrid(int $teamCount): array;

    public function getPlayedMatches(array $weeks): array;
}
