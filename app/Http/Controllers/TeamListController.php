<?php

namespace App\Http\Controllers;

use App\Contracts\GenerateMatchesInterface;
use App\Http\Requests\UpdateMatchRequest;
use App\Http\Resources\TeamListResource;
use App\Models\MatchResult;
use App\Models\Team;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TeamListController extends Controller
{
    /**
     * @param int $team_count
     * @return AnonymousResourceCollection
     */
    public function getTeams(int $team_count = 4): AnonymousResourceCollection
    {
        return TeamListResource::collection(Team::getTeamList($team_count));
    }

//    /**
//     * @param GenerateMatchesInterface $matches
//     * @param UpdateMatchRequest $request
//     * @return Application|ResponseFactory|\Illuminate\Http\Response
//     */
//    public function updateMatch(GenerateMatchesInterface $matches, UpdateMatchRequest $request)
//    {
//        try {
//            MatchResult::updateMatchResult(
//                $request->only(['week', 'home_name']),
//                $request->prepareData($matches)
//            );
//
//            return response('ok');
//        } catch (Exception $exception) {
//            Log::error('MatchResultControllerUpdateError: ' . $exception->getMessage());
//
//            return response('Failed update the match!', Response::HTTP_UNPROCESSABLE_ENTITY);
//        }
//    }
}
