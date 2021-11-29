<?php

namespace App\Http\Controllers;

use App\Contracts\PredictionInterface;
use App\Http\Resources\PredictionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PredictionController extends Controller
{
    public function __invoke(PredictionInterface $prediction): AnonymousResourceCollection
    {
        return PredictionResource::collection($prediction->getPrediction());
    }
}
