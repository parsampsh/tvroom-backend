<?php

namespace App\Http\Resources;

use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'en_title' => $this->en_title,
            'img' => $this->img,
            'description' => $this->description,
            'user' => (new UserResource(resolve(UserRepository::class)->findById($this->user_id))),
        ];
    }
}
