<?php

namespace App\Http\Controllers;

use App\Contracts\GenerateMatchesInterface;
use App\Models\MatchResult;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateMatchesController extends Controller
{
    public GenerateMatchesInterface $generateMatches;

    public function __construct(GenerateMatchesInterface $generateMatches)
    {
        $this->generateMatches = $generateMatches;
    }

    public function __invoke(int $teamCount = 20)
    {
        try {
            $matchesGrid = $this->generateMatches->getMatchesGrid();
            MatchResult::saveMatches($this->generateMatches->getPlayedMatches($matchesGrid));
        } catch (Exception $exception) {
            Log::error('GenerateMatchesError: ' . $exception->getMessage());
            return response('Error: ' . $exception->getMessage(), $exception->getCode());
        }

        return response('ok');
    }
}
