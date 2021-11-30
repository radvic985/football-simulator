<?php

namespace App\Models;

use App\Models\Traits\ChampionQueryHelperTrait;
use App\Models\Traits\ChampionRelationTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $team_id
 * @property int $played
 * @property int $won
 * @property int $drawn
 * @property int $lost
 * @property int $gf
 * @property int $ga
 * @property int $gd
 * @property int $points
 * @property int $prev_pos
 * @property int $pos
 *
 * @property int|float $percent only read without saving to db
 *
 * @mixin ChampionQueryHelperTrait
 */
class Champion extends Model
{
    use ChampionQueryHelperTrait;
    use ChampionRelationTrait;

    const TABLE = 'champions';

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
        'team_id',
        'played',
        'won',
        'drawn',
        'lost',
        'gf',
        'ga',
        'gd',
        'points',
        'prev_pos',
        'pos',
    ];
}
