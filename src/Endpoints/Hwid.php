<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Hwid extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/users';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function get(string $userId, array $query = [], array $headers = []): array
    {
        $path = "/{$userId}/hwids";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function delete(string $userId, string $hwid, array $query = [], array $headers = []): array
    {
        $path = "/{$userId}/hwids/{$hwid}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function reset(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$userId}/hwids/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
}