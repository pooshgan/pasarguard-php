<?php

namespace Pooshgan\PasarGuard\Endpoints;

use Pooshgan\PasarGuard\Client;

abstract class AbstractEndpoint
{
    protected Client $client;
    protected string $pathPrefix = '';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}