<?php

namespace App\Http\Resources;

use App\Models\Champion;
use Illuminate\Http\Resources\Json\JsonResource;

class ChampionResource extends JsonResource
{
    /**
     * @var Champion
     */
    public $resource;

    public function toArray($request): array
    {
        return [
            'pos' => $this->resource->pos,
            'is_up' => $this->resource->prev_pos <=> $this->resource->pos,
            'name' => $this->resource->team->name,
            'points' => $this->resource->points,
            'played' => $this->resource->played,
            'won' => $this->resource->won,
            'drawn' => $this->resource->drawn,
            'lost' =>  $this->resource->lost,
            'gf' => $this->resource->gf,
            'ga' => $this->resource->ga,
            'gd' => $this->resource->gd,
            'team_id' => $this->resource->team_id,
        ];
    }
}
