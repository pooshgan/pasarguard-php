<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Group extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/groups';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function create(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function list(array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function listSimple(array $query = [], array $headers = []): array
    {
        $path = "/simple";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function get(string $groupId, array $query = [], array $headers = []): array
    {
        $path = "/{$groupId}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function update(string $groupId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$groupId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function delete(string $groupId, array $query = [], array $headers = []): array
    {
        $path = "/{$groupId}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function bulkAdd(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/add";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkRemove(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/remove";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
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