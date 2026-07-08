<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PageObserver
{
    public function saved(Page $page): void
    {
        $this->triggerRebuild();
    }

    public function deleted(Page $page): void
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
