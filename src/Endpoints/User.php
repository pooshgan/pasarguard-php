<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class User extends AbstractEndpoint
{
    protected string $pathPrefix = '/api/users';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function create(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function update(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$username}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function setDisabled(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$username}/disabled";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function setDisabledByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/disabled";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function setDisabledById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/disabled";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function delete(string $username, array $query = [], array $headers = []): array
    {
        $path = "/{$username}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteById(string $userId, array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function resetDataUsage(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$username}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetDataUsageByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetDataUsageById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function revokeSubscription(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$username}/revoke_sub";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function revokeSubscriptionByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/revoke_sub";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function revokeSubscriptionById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/revoke_sub";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetAllDataUsage(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function getSubUpdateChart(array $query = [], array $headers = []): array
    {
        $path = "/sub_update/chart";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function setOwner(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$username}/set_owner";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function setOwnerByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/set_owner";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function setOwnerById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/set_owner";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function activeNextPlan(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/{$username}/active_next";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function activeNextPlanByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/active_next";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function activeNextPlanById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/active_next";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function get(string $username, array $query = [], array $headers = []): array
    {
        $path = "/{$username}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getById(string $userId, array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getSubscriptionById(string $userId, string $clientType, array $query = [], array $headers = []): array
    {
        $path = "/{$userId}/subscription/{$clientType}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getSubUpdateList(string $username, array $query = [], array $headers = []): array
    {
        $path = "/{$username}/sub_update";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getSubUpdateListByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/sub_update";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getSubUpdateListById(string $userId, array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/sub_update";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
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
    public function getUsage(string $username, array $query = [], array $headers = []): array
    {
        $path = "/{$username}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsageByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/by-username/{$username}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsageById(string $userId, array $query = [], array $headers = []): array
    {
        $path = "/by-id/{$userId}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getAllUsage(array $query = [], array $headers = []): array
    {
        $path = "/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsersCountMetric(string $metric, array $query = [], array $headers = []): array
    {
        $path = "/counts/{$metric}";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getExpired(array $query = [], array $headers = []): array
    {
        $path = "/expired";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteExpired(array $query = [], array $headers = []): array
    {
        $path = "/expired";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function bulkDelete(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/delete";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkReset(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/reset";
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
    public function bulkRevokeSub(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/revoke_sub";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkSetOwner(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/set_owner";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function createFromTemplate(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/from_template";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkCreateFromTemplate(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/from_template";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkApplyTemplate(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/apply_template";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateWithTemplate(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/from_template/{$username}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateWithTemplateByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/from_template/by-username/{$username}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateWithTemplateById(string $userId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/from_template/by-id/{$userId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkModifyExpire(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/expire";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkModifyDataLimit(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/data_limit";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkModifyProxySettings(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/proxy_settings";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkReallocateWireguardPeerIps(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/bulk/wireguard/reallocate-peer-ips";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
}