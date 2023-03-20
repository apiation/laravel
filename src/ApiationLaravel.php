<?php

namespace Apiation\ApiationLaravel;

use Apiation\ApiationLaravel\Jobs\RecordEvent;

class ApiationLaravel
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     */
    public function record($request, $response)
    {
        if (! $this->shouldRecord()) {
            return;
        }
        if ($this->shouldQueue()) {
            return $this->recordOnQueue($request, $response);
        }

        return $this->recordNow($request, $response);
    }

    protected function shouldRecord()
    {
        $sampleRate = (float) config('apiation.sample_rate');

        return random_int(1, 100) / 100.0 > $sampleRate;
    }

    protected function shouldQueue()
    {
        return ! is_null(config('apiation.queued'));
    }

    protected function recordOnQueue(\Illuminate\Http\Request $request, \Illuminate\Http\JsonResponse $response)
    {
        RecordEvent::dispatch($request, $response)
            ->onQueue(config('apiation.queue.queue'))
            ->onConnection(config('apiation.queue.connection'));
    }

    protected function recordNow(\Illuminate\Http\Request $request, \Illuminate\Http\JsonResponse $response)
    {
        RecordEvent::dispatchSync($request, $response);
    }
}
