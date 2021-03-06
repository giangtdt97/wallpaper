<?php

namespace App\Http\Resources;

use App\Models\Visitor;
use App\Models\VisitorFavorite;
use App\Models\WallpaperFavorite;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class WallpaperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'categories' =>
                CategoryResource::collection($this->categories),
            'id' => $this->id,
            'name' => $this->name,
            'thunbnail_image' => asset('storage/' . $this->thumbnail_image),
            'image' => asset('storage/' . $this->image),
            'like_count' => $this->like_count,
            'views' => $this->view_count,
            'feature' => $this->feature,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }


}
