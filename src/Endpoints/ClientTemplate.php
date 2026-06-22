<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class ClientTemplate extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/client_templates';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function create(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function get(string $templateId, array $query = [], array $headers = []): array
    {
        $path = "/{$templateId}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function update(string $templateId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$templateId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function delete(string $templateId, array $query = [], array $headers = []): array
    {
        $path = "/{$templateId}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
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
    public function bulkDelete(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/delete";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
}