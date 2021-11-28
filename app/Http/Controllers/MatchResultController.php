<?php

namespace App\Http\Controllers;

use App\Contracts\CalculateLeagueTableInterface;
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
    public function __invoke(CalculateLeagueTableInterface $leagueTable, int $week = null)
    {
        try {
            DB::beginTransaction();
            $leagueTable->calculateTable($week);
            DB::commit();

            return MatchResultResource::collection(MatchResult::getMatchResults($week));
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('MatchResultControllerError: ' . $exception->getMessage());

            return response('Error: ' . $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }
}
