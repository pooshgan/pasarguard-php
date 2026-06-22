<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Host extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/hosts';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function get(string $hostId, array $query = [], array $headers = []): array
    {
        $path = "/{$hostId}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function list(array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function create(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function update(string $hostId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$hostId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function delete(string $hostId, array $query = [], array $headers = []): array
    {
        $path = "/{$hostId}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function updateAll(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkDelete(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/delete";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkDisable(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/disable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkEnable(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/enable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
}