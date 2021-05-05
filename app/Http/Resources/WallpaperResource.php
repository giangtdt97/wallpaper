<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WallpaperResource extends JsonResource
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
            'name' => $this->name,
            'thunbnail_image' => asset('storage/'.$this->thumbnail_image),
            'image' => asset('storage/'.$this->image),
            'like_count' => $this->like_count,
            'feature' => $this->feature,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
