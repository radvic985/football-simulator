<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamListResource;
use App\Models\Team;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TeamListController extends Controller
{
    /**
     * @param int $team_count
     * @return AnonymousResourceCollection
     */
    public function __invoke(int $team_count = 4): AnonymousResourceCollection
    {
        return TeamListResource::collection(Team::getTeamList($team_count));
    }
}
