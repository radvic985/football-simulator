<?php

namespace App\Http\Resources;

use App\Models\Champion;
use Illuminate\Http\Resources\Json\JsonResource;

class PredictionResource extends JsonResource
{
    /**
     * @var Champion
     */
    public $resource;

    public function toArray($request): array
    {
        return [
            'team_id' => $this->resource->team->id,
            'name' => $this->resource->team->name,
            'percent' => $this->resource->percent . ' %',
        ];
    }
}
