<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(10)
            ->through(fn (Post $post) => $this->transform($post));
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        return $this->transform($post);
    }

    private function transform(Post $post): array
    {
        return [
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'content' => $post->content,
            'category' => $post->category?->name,
            'featured_image' => $post->getFirstMediaUrl('featured_image') ?: null,
            'published_at' => $post->published_at?->toIso8601String(),
        ];
    }
}
