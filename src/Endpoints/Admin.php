<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

class Admin extends AbstractEndpoint
{
    protected string $pathPrefix = '/api';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function getToken(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admin/token";
        return $this->client->request('POST', $this->pathPrefix . $path, ['form_params' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function getMiniAppToken(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admin/miniapp/token";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function create(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function update(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function updateById(string $adminId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}";
        return $this->client->request('PUT', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function delete(string $username, array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteById(string $adminId, array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function list(array $query = [], array $headers = []): array
    {
        $path = "/admins";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function listSimple(array $query = [], array $headers = []): array
    {
        $path = "/admins/simple";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsage(string $username, array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsageByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function getUsageById(string $adminId, array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}/usage";
        return $this->client->request('GET', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function disableUsers(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}/users/disable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function disableUsersByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}/users/disable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function disableUsersById(string $adminId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}/users/disable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function activateUsers(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}/users/activate";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function activateUsersByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}/users/activate";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function activateUsersById(string $adminId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}/users/activate";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function deleteUsers(string $username, array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}/users";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteUsersByUsername(string $username, array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}/users";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function deleteUsersById(string $adminId, array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}/users";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
    public function resetUsage(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/{$username}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetUsageByUsername(string $username, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-username/{$username}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function resetUsageById(string $adminId, array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/by-id/{$adminId}/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkDelete(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/delete";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkReset(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/reset";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkDisable(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/disable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkEnable(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/enable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkDisableUsers(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/users/disable";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkActivateUsers(array $data = [], array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/users/activate";
        return $this->client->request('POST', $this->pathPrefix . $path, ['json' => $data, 'query' => $query, 'headers' => $headers]);
    }
    public function bulkDeleteUsers(array $query = [], array $headers = []): array
    {
        $path = "/admins/bulk/users";
        return $this->client->request('DELETE', $this->pathPrefix . $path, ['query' => $query, 'headers' => $headers]);
    }
}