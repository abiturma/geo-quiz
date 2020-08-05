<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'level' => $this->level,
            'xp' => $this->xp,
            'next_level_xp' => $this->next_level->goal(),
            'current_level_xp' => $this->next_level->current()
        ];
    }
}
