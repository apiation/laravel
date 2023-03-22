<?php

namespace Apiation\ApiationLaravel;

use Apiation\ApiationLaravel\Jobs\RecordEvent;

class ApiationLaravel
{
    public function record(\Illuminate\Http\Request $request, \Illuminate\Http\JsonResponse $response): void
    {
        if (! $this->shouldRecord()) {
            return;
        }

        if ($this->shouldQueue()) {
            $this->recordOnQueue($request, $response);

            return;
        }

        $this->recordNow($request, $response);
    }

    protected function shouldRecord(): bool
    {
        $sampleRate = (float) config('apiation.sample_rate');

        return random_int(1, 100) / 100.0 > $sampleRate;
    }

    protected function shouldQueue(): bool
    {
        return ! is_null(config('apiation.queued'));
    }

    protected function recordOnQueue(\Illuminate\Http\Request $request, \Illuminate\Http\JsonResponse $response): void
    {
        RecordEvent::dispatch($request, $response)
            ->onQueue(config('apiation.queue.queue'))
            ->onConnection(config('apiation.queue.connection'));
    }

    protected function recordNow(\Illuminate\Http\Request $request, \Illuminate\Http\JsonResponse $response): void
    {
        RecordEvent::dispatchSync($request, $response);
    }
}
