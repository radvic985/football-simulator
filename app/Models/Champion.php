<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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
 * @see Champion::team()
 * @property Team|null $team
 */
class Champion extends Model
{
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

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public static function getChampions()
    {
        return static::with('team')->orderBy('pos')->get();
    }

    public static function updateLeagueTable(array $teamId, array $data)
    {
        static::query()->updateOrCreate($teamId, $data);
    }

    public static function getSortedLeagueTable()
    {
        return static::query()
            ->orderByDesc('points')
            ->orderByDesc('gd')
            ->get();
    }

    public static function truncateTable()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(static::TABLE)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
