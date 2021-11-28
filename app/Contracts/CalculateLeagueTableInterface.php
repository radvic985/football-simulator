<?php

namespace App\Contracts;

interface CalculateLeagueTableInterface
{
    public function calculateTable(int $week): void;
}
