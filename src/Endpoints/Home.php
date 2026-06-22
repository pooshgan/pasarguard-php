<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Home extends AbstractEndpoint
{
    protected string $pathPrefix = '/api';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function health(array $query = [], array $headers = []): array
    {
        $path = "/health";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
}