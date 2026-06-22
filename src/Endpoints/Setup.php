<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Setup extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/setup';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function createOwner(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/owner";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetOwnerPassword(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/owner";
        return $this->client->request('PATCH', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function deleteOwner(array $query = [], array $headers = []): array
    {
        $path = "/owner";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function upgradeOwner(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/owner/upgrade";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
}