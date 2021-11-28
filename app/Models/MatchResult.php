<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $week
 * @property int $home_team_id
 * @property int $guest_team_id
 * @property int $home_goals
 * @property int $guest_goals
 *
 * @see MatchResult::homeTeam()
 * @property Team|null $homeTeam
 *
 * @see MatchResult::guestTeam()
 * @property Team|null $guestTeam
 */
class MatchResult extends Model
{
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

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'id');
    }

    public function guestTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'guest_team_id', 'id');
    }

    public static function getMatchResults(?int $week)
    {
//        Log::info('week = ' . $week);
//        Log::info('=================');

//        dd(!is_null($week));
        return self::with(['homeTeam', 'guestTeam'])
            ->when($week, function (Builder $query, $week) {
//                dd($week);
                return $query->where('week', $week);
            })
//            ->where('week', $week)
            ->orderBy('week')
            ->get();
//        return self::with(['homeTeam', 'guestTeam'])
//            ->when(!is_null($week), function (Builder $query, $week) {
//                return $query->where('week', $week);
//            })
//            ->orderBy('week')
//            ->get();
    }
}
