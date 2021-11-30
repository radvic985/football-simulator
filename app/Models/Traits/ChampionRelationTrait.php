<?php

namespace App\Models\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @see ChampionRelationTrait::team()
 * @property Team|null $team
 */
trait ChampionRelationTrait
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
