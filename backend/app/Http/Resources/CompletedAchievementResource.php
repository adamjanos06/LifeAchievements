<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompletedAchievementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'achievement' => new AchievementResource($this->achievement),
            'completion_date' => $this->completion_date,
            'notes' => $this->notes,
        ];
    }
}
