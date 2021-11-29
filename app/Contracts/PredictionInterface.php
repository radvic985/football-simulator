<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface PredictionInterface
{
    public function getPrediction(): Collection;
}
