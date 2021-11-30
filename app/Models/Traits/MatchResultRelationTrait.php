<?php

namespace App\Models\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @see MatchResultRelationTrait::homeTeam()
 * @property Team|null $homeTeam
 *
 * @see MatchResultRelationTrait::guestTeam()
 * @property Team|null $guestTeam
 */
trait MatchResultRelationTrait
{
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'id');
    }

    public function guestTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'guest_team_id', 'id');
    }
}
