# PasarGuard PHP SDK

A production-ready, strongly-typed PHP library for interacting with the [PasarGuard Panel](https://github.com/PasarGuard/panel.git) API.

## Installation

```bash
composer require pooshgan/pasarguard-php
```

## Usage

```php
<?php
require 'vendor/autoload.php';

use Pooshgan\PasarGuard\Client;
use Pooshgan\PasarGuard\PasarGuard;

// Initialize the client with your panel URL and Admin Token
$client = new Client('https://your-panel-domain.com', 'your-admin-token');
$api = new PasarGuard($client);

// Get all users
$users = $api->users->list();

// Create a new user
$newUser = $api->users->create([
    'username' => 'test_user',
    'status' => 'active',
    'data_limit' => 1073741824
]);

// Get specific user by username
$user = $api->users->getByUsername('test_user');
```

## Features
- **Strongly Typed**: All API endpoints are mapped to explicit methods with correct path parameters.
- **Guzzle Powered**: Uses GuzzleHTTP for reliable, production-grade HTTP requests.
- **Complete Coverage**: Covers 100% of the PasarGuard API surface (Users, Nodes, Cores, Admins, Settings, etc.).
- **Flexible Auth**: Supports Bearer Token auth and custom headers (e.g., for Telegram MiniApp auth).

## Endpoints
All endpoints are accessible via the main `PasarGuard` class:
- `$api->adminRoles`
- `$api->users`
- `$api->hosts`
- `$api->groups`
- `$api->hwids`
- `$api->setup`
- `$api->system`
- `$api->cores`
- `$api->nodes`
- `$api->subscriptions`
- `$api->userTemplates`
- `$api->admins`
- `$api->settings`
- `$api->clientTemplates`
- `$api->home`

## Credits
- **Original Panel**: [PasarGuard](https://github.com/PasarGuard/panel.git)
- **SDK Author**: [pooshgan](https://github.com/pooshgan)