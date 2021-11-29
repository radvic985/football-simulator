<?php

namespace App\Http\Requests;

use App\Contracts\GenerateMatchesInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $home_name
 * @property int $home_goals
 * @property int $guest_goals
 * @property int $week
 */
class UpdateMatchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'home_name' => 'required|string',
            'home_goals' => 'required|int',
            'guest_goals' => 'required|int',
            'week' => 'required|int',
        ];
    }

    public function prepareData(GenerateMatchesInterface $matches): array
    {
        return array_merge(
            $this->only(['home_goals', 'guest_goals']),
            [
                'home_pts' => $matches->getPoints($this->home_goals, $this->guest_goals),
                'guest_pts' => $matches->getPoints($this->guest_goals, $this->home_goals),
            ]
        );
    }
}
