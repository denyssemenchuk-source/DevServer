<?php

namespace App\Http\Resources\Api\Blog\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'parent_id'      => $this->parent_id,
            // Використовуємо аксесуар, який ви створили в попередніх завданнях
            'parent_title'   => $this->parent_title,
        ];
    }
}
