<?php

namespace App\Http\Controllers\Api\Blog;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = BlogPost::all();

        return $items;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Шукаємо пост за ID.
        // Додаємо with(['user', 'category']), щоб одразу отримати ім'я автора та назву категорії
        $post = BlogPost::with(['user', 'category'])->find($id);

        if (!$post) {
            return response()->json(['message' => 'Пост не знайдено'], 404);
        }

        // Повертаємо знайдений пост
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
