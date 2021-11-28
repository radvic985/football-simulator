<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChampionResource;
use App\Models\Champion;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChampionshipController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return ChampionResource::collection(Champion::getChampions());
    }
}
