<?php

namespace App\Models;

use App\Models\Traits\MatchResultQueryHelperTrait;
use App\Models\Traits\MatchResultRelationTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $week
 * @property int $home_team_id
 * @property int $guest_team_id
 * @property int $home_goals
 * @property int $guest_goals
 *
 * @mixin MatchResultQueryHelperTrait
 * @mixin MatchResultRelationTrait
 */
class MatchResult extends Model
{
    use MatchResultQueryHelperTrait;
    use MatchResultRelationTrait;

    const TABLE = 'match_results';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = self::TABLE;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'week',
        'home_team_id',
        'guest_team_id',
        'home_goals',
        'guest_goals',
    ];
}
