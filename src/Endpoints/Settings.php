<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Settings extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/settings';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function get(array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getGeneral(array $query = [], array $headers = []): array
    {
        $path = "/general";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function update(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
}