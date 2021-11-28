<?php

namespace App\Http\Resources;

use App\Models\MatchResult;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResultResource extends JsonResource
{
    /**
     * @var MatchResult
     */
    public $resource;

    public function toArray($request): array
    {
        return [
            'home_name' => $this->resource->homeTeam->name,
            'guest_name' => $this->resource->guestTeam->name,
            'home_goals' => $this->resource->home_goals,
            'guest_goals' => $this->resource->guest_goals,
            'week' => $this->resource->week,
        ];
    }
}
