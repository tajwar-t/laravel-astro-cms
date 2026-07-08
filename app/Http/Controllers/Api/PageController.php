<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return [
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
            'template' => $page->template,
            'meta' => $page->meta,
        ];
    }
}
