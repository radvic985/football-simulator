<?php

namespace App\Http\Controllers;

use App\Contracts\CalculateLeagueTableInterface;
use App\Contracts\GenerateMatchesInterface;
use App\Http\Requests\UpdateMatchRequest;
use App\Http\Resources\MatchResultResource;
use App\Models\MatchResult;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MatchResultController extends Controller
{
    /**
     * @param CalculateLeagueTableInterface $leagueTable
     * @param int|null $week
     * @return Application|ResponseFactory|AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function getMatches(CalculateLeagueTableInterface $leagueTable, int $week = null)
    {
        try {
            DB::beginTransaction();
            $leagueTable->calculateTable($week);
            DB::commit();

            return MatchResultResource::collection(MatchResult::getMatchResults($week));
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('MatchResultControllerError: ' . $exception->getMessage());

            return response('Failed get matches!', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param GenerateMatchesInterface $matches
     * @param UpdateMatchRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function updateMatch(GenerateMatchesInterface $matches, UpdateMatchRequest $request)
    {
        try {
            MatchResult::updateMatchResult(
                $request->only(['week', 'home_name']),
                $request->prepareData($matches)
            );

            return response('ok');
        } catch (Exception $exception) {
            Log::error('MatchResultControllerUpdateError: ' . $exception->getMessage());

            return response('Failed update the match!', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
