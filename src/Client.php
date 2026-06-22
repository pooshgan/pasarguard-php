<?php

namespace Pooshgan\PasarGuard;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Pooshgan\PasarGuard\Exceptions\PasarGuardException;

class Client
{
    protected GuzzleClient $httpClient;
    protected string $subscriptionPath;

    public function __construct(string $baseUrl, string $token, string $subscriptionPath = '/sub', array $guzzleOptions = [])
    {
        $this->subscriptionPath = $subscriptionPath;
        
        $this->httpClient = new GuzzleClient(array_merge([
            'base_uri' => rtrim($baseUrl, '/'),
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ], $guzzleOptions));
    }

    public function request(string $method, string $uri, array $options = []): array
    {
        // Allow overriding subscription path if configured differently in env
        if (str_starts_with($uri, '/sub')) {
            $uri = $this->subscriptionPath . substr($uri, 4);
        }

        try {
            $response = $this->httpClient->request($method, ltrim($uri, '/'), $options);
            $body = (string) $response->getBody();
            $data = json_decode($body, true);

            if ($response->getStatusCode() >= 400) {
                throw new PasarGuardException(
                    $data['detail'] ?? 'API Error',
                    $response->getStatusCode(),
                    $data ?: []
                );
            }

            return is_array($data) ? $data : ['raw' => $body];
        } catch (GuzzleException $e) {
            throw new PasarGuardException('HTTP Request Failed: ' . $e->getMessage(), $e->getCode(), [], $e);
        }
    }
}