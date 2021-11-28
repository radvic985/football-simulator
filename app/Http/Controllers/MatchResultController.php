<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatchResultResource;
use App\Models\MatchResult;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MatchResultController extends Controller
{
    public function __invoke($week = null): AnonymousResourceCollection
    {
        return MatchResultResource::collection(MatchResult::getMatchResults($week));
    }
}
