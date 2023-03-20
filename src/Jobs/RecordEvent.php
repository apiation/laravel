<?php declare(strict_types=1);

namespace Apiation\ApiationLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Factory;
use Illuminate\Queue\InteractsWithQueue;

class RecordEvent
{
    use Queueable, Dispatchable, InteractsWithQueue;

    public const URL = "https://apiation.io/api/v1/record";
    public $request;
    public $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function handle(Factory $http)
    {
        $http
            ->async(config('apiation.async'))
            ->acceptJson()
            ->withToken(config('apiation.token'))
            ->timeout(5)
            ->retry(2)
            ->post(self::URL, [
                'path' => $this->request->route()->uri(),
                'method' => $this->request->getMethod(),
                'status' => $this->response->getStatusCode(),
                'request' => [
                    'body' => json_encode($this->request->input()),
                    'headers' => json_encode($this->request->headers->all()),
                    'query' => json_encode($this->request->query->all()),
                ],
                'response' => [
                    'body' => json_encode($this->response->getData()),
                    'headers' => json_encode($this->response->headers->all()),
                ],
                'sample_rate' => config('apiation.sample_rate')
            ]);
    }
}
