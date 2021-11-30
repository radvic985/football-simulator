<?php

namespace App\Http\Controllers;

use App\Contracts\GenerateMatchesInterface;
use App\Http\Requests\GenerateRequest;
use App\Models\Champion;
use App\Models\MatchResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GenerateMatchesController extends Controller
{
    public function __invoke(GenerateRequest $request, GenerateMatchesInterface $generateMatches)
    {
        try {
            DB::beginTransaction();

            $matchesGrid = $generateMatches->getMatchesGrid($request->team_count);
            MatchResult::saveMatches($generateMatches->getPlayedMatches($matchesGrid, $request->prepareStrengths()));
            Champion::truncateTable();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('GenerateMatchesError: ' . $exception->getMessage());

            return response('Error: ' . $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response('ok');
    }
}
