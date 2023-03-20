<?php

declare(strict_types=1);

namespace Apiation\ApiationLaravel\Jobs;

use Apiation\ApiationLaravel\Scrambler;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class RecordEvent
{
    use Queueable, Dispatchable, InteractsWithQueue;

    public const URL = 'https://apiation.io/api/v1/record';

    public function __construct(public Request $request, public JsonResponse $response)
    {
    }

    public function handle(Factory $http)
    {
        $http
            ->async((bool) config('apiation.async'))
            ->acceptJson()
            ->withToken((string) config('apiation.token'))
            ->timeout(5)
            ->retry(2)
            ->post(self::URL, [
                'host' => $this->request->httpHost(),
                'path' => $this->request->route()?->uri(),
                'method' => $this->request->getMethod(),
                'status' => $this->response->getStatusCode(),
                'request' => [
                    'body' => $this->parse($this->request->input()),
                    'headers' => $this->parse($this->request->headers->all()),
                    'query' => $this->parse($this->request->query->all()),
                ],
                'response' => [
                    'body' => $this->parse($this->response->getData()),
                ],
                'sample_rate' => (float) config('apiation.sample_rate'),
            ]);
    }

    private function parse($input) : string
    {
        if(config('apiation.scramble')) {
            $input = Scrambler::scramble($input);
        }

        return json_encode($input);
    }
}
