<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class PostResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->collection->map(function ($post) {
            $categories = $post->categories ? $post->categories->pluck('name')->take(3) : collect([]);

            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => Str::limit($post->content, 50),
                'categories' => $categories,
                'more_categories_link' => $post->categories && $post->categories->count() > 3 ? url("/api/v1/posts/{$post->id}/categories") : null,
                'created_at' => Carbon::parse($post->created_at)->format('d/m/Y H:i:s'),
            ];
        })->toArray();
    }

}
