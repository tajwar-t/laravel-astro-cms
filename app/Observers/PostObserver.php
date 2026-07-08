<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    public function saved(Post $post): void
    {
        $this->triggerRebuild();
    }

    public function deleted(Post $post): void
    {
        $this->triggerRebuild();
    }

    private function triggerRebuild(): void
    {
        $webhookUrl = config('services.deploy.webhook_url');

        if (! $webhookUrl) {
            return;
        }

        try {
            Http::post($webhookUrl);
        } catch (\Throwable $e) {
            Log::warning('Astro rebuild webhook failed: ' . $e->getMessage());
        }
    }
}
