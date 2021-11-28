<?php

namespace App\Http\Requests;

use App\Support\Constants;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $team_count
 */
class GenerateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'team_count' => 'required|int|in:' . collect(Constants::AVAILABLE_TEAM_COUNTS)->implode(','),
        ];
    }
}
