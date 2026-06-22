<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Subscription extends AbstractEndpoint
{
    protected string $pathPrefix = '/sub';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function get(string $token, array $query = [], array $headers = []): array
    {
        $path = "/{$token}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getInfo(string $token, array $query = [], array $headers = []): array
    {
        $path = "/{$token}/info";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getRaw(string $token, array $query = [], array $headers = []): array
    {
        $path = "/{$token}/raw";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getApps(string $token, array $query = [], array $headers = []): array
    {
        $path = "/{$token}/apps";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsage(string $token, array $query = [], array $headers = []): array
    {
        $path = "/{$token}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getWithClientType(string $token, string $clientType, array $query = [], array $headers = []): array
    {
        $path = "/{$token}/{$clientType}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
}