<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamListResource extends JsonResource
{
    /**
     * @var Team
     */
    public $resource;

    public function toArray($request): array
    {
        return [
            'team_id' => $this->resource->id,
            'name' => $this->resource->name,
            'strength' => $this->resource->id,
        ];
    }
}
