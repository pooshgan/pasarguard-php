<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Node extends AbstractEndpoint
{
    protected string $pathPrefix = '/api';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function getSettings(array $query = [], array $headers = []): array
    {
        $path = "/node/settings";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsage(array $query = [], array $headers = []): array
    {
        $path = "/node/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUserCountMetric(string $metric, array $query = [], array $headers = []): array
    {
        $path = "/node/user_counts/{$metric}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function list(array $query = [], array $headers = []): array
    {
        $path = "/nodes";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function listSimple(array $query = [], array $headers = []): array
    {
        $path = "/nodes/simple";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function reconnectAll(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/reconnect";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function create(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function get(string $nodeId, array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function updateNode(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/update";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateCore(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/core_update";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateGeofiles(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/geofiles";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function update(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetUsage(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function reconnect(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/reconnect";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function sync(string $nodeId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/sync";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function delete(string $nodeId, array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getLogs(string $nodeId, array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/logs";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getStatsPeriodic(string $nodeId, array $query = [], array $headers = []): array
    {
        $path = "/nodes/{$nodeId}/stats";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
}