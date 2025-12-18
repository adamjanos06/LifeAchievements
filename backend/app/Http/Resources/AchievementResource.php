<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_id' =>$this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'xp' => $this->xp,
            'difficulty' => $this->difficulty,
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
