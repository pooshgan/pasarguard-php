<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class System extends AbstractEndpoint
{
    protected string $pathPrefix = '/api';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function getStats(array $query = [], array $headers = []): array
    {
        $path = "/system";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getResourceStats(array $query = [], array $headers = []): array
    {
        $path = "/system/resources";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsersStats(array $query = [], array $headers = []): array
    {
        $path = "/system/users";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getInbounds(array $query = [], array $headers = []): array
    {
        $path = "/inbounds";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getInboundDetails(array $query = [], array $headers = []): array
    {
        $path = "/inbounds/details";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getWorkersHealth(array $query = [], array $headers = []): array
    {
        $path = "/workers/health";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
}