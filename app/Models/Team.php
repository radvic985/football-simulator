<?php

namespace App\Models;

use App\Models\Traits\TeamQueryHelperTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @mixin TeamQueryHelperTrait
 */
class Team extends Model
{
    use TeamQueryHelperTrait;

    const TABLE = 'teams';

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
        'name',
    ];
}
