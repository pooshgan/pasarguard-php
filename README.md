# PasarGuard PHP SDK

<div align="center">

![PHP](https://img.shields.io/badge/PHP-%3E%3D8.1-blue.svg?style=flat-square&logo=php)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)
![Packagist](https://img.shields.io/packagist/v/pooshgan/pasarguard-php.svg?style=flat-square)
![Coverage](https://img.shields.io/badge/API_Coverage-100%25-brightgreen.svg?style=flat-square)

**A production-ready, strongly-typed PHP SDK for the [PasarGuard Panel](https://github.com/PasarGuard/panel) API.**

[Installation](#installation) •
[Quick Start](#quick-start) •
[Endpoints](#endpoints) •
[Examples](#real-world-examples) •
[Error Handling](#error-handling) •
[Advanced](#advanced-usage)

📖 [English README](README.md) | 📖 [فارسی](README.fa.md)

</div>

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Architecture](#architecture)
- [Endpoints](#endpoints)
  - [Users](#users)
  - [Admins](#admins)
  - [Admin Roles](#admin-roles)
  - [Nodes](#nodes)
  - [Cores](#cores)
  - [Hosts](#hosts)
  - [Groups](#groups)
  - [HWIDs](#hwids)
  - [Subscriptions](#subscriptions)
  - [User Templates](#user-templates)
  - [Client Templates](#client-templates)
  - [Settings](#settings)
  - [System](#system)
  - [Setup](#setup)
  - [Home](#home)
- [Real-World Examples](#real-world-examples)
- [Error Handling](#error-handling)
- [Advanced Usage](#advanced-usage)
- [API Reference](#api-reference)
- [Credits](#credits)
- [License](#license)

---

## Overview

**PasarGuard PHP SDK** is a fully-typed, ergonomic client library for interacting with the PasarGuard Panel API. It is built on top of [GuzzleHTTP](https://github.com/guzzle/guzzle) and follows modern PHP 8.1+ conventions including strict typing, PSR-4 autoloading, and predictable method signatures.

The SDK covers **100% of the PasarGuard API surface**, exposing every endpoint (Users, Nodes, Cores, Admins, Hosts, Groups, Subscriptions, Templates, Settings, System stats, HWID management, and more) through a clean, chainable object-oriented interface. Every method maps 1:1 to an API route, with parameters strongly typed and request payloads normalized to PHP arrays.

Whether you are building a custom dashboard, automating user provisioning, integrating billing, or running a Telegram Mini App backed by PasarGuard, this SDK gives you a stable foundation without the boilerplate of raw HTTP calls.

---

## Features

- **Strongly Typed** — Every endpoint method has explicit parameter types and returns a typed `array`. No magic, no surprises.
- **Guzzle Powered** — Built on Guzzle 7, the de-facto standard for production HTTP in PHP. Supports middlewares, async calls, custom handlers, and connection pooling out of the box.
- **100% API Coverage** — Implements every endpoint exposed by the PasarGuard Panel REST API, including bulk operations, by-username / by-id variants, and admin user-management flows.
- **Flexible Auth** — Out-of-the-box Bearer token auth, plus full support for injecting custom headers per-request (e.g., Telegram Mini App auth).
- **Configurable Subscription Path** — If your panel uses a non-default subscription path (e.g., `/sub` vs. `/custom-sub`), pass it once to the `Client` constructor and every related endpoint is rewritten automatically.
- **Consistent Error Handling** — All non-2xx responses raise a single `PasarGuardException` carrying the HTTP status code and the raw error payload, so you can centralize retries, logging, and user-facing messages.
- **PSR-4 Autoloading** — `composer install` and you are ready. No manual includes, no `require_once` chains.
- **No Hidden State** — The SDK is stateless per call; safe to share a single `PasarGuard` instance across a long-running process (queue workers, daemons, Swoole handlers).
- **Bulk Operations** — First-class support for bulk delete / reset / disable / enable / set-owner / modify-expire / modify-data-limit / modify-proxy-settings / wireguard-reallocate operations on users, admins, hosts, groups, and templates.

---

## Requirements

| Requirement | Version |
|-------------|---------|
| PHP         | `>= 8.1` |
| GuzzleHTTP  | `^7.0`  |
| ext-json    | bundled |
| ext-curl    | recommended (Guzzle default handler) |

The SDK is framework-agnostic: it works equally well inside Laravel, Symfony, Yii, CodeIgniter, CakePHP, plain PHP scripts, or long-running workers (RoadRunner, Swoole, FrankenPHP).

---

## Installation

Install via Composer:

```bash
composer require pooshgan/pasarguard-php
```

If you don't have Composer yet:

```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar require pooshgan/pasarguard-php
```

After installation, include the Composer autoloader in your entry-point file:

```php
<?php
require 'vendor/autoload.php';
```

---

## Quick Start

```php
<?php
require 'vendor/autoload.php';

use Pooshgan\PasarGuard\Client;
use Pooshgan\PasarGuard\PasarGuard;

// 1. Initialize the HTTP client with your panel URL and admin token
$client = new Client(
    baseUrl: 'https://your-panel-domain.com',
    token:  'your-admin-bearer-token'
);

// 2. Wrap it with the high-level SDK facade
$api = new PasarGuard($client);

// 3. Call any endpoint group as a property
$users = $api->users->list();
print_r($users);

// 4. Create a new user with a data limit of 1 GB
$newUser = $api->users->create([
    'username'   => 'test_user',
    'status'     => 'active',
    'data_limit' => 1073741824, // bytes
    'expire'     => (time() + 86400 * 30) * 1000, // ms since epoch
]);

echo "Created user ID: " . $newUser['id'] . PHP_EOL;
```

---

## Architecture

The SDK is intentionally small and follows a layered design:

```
┌──────────────────────────────────────────────────────────┐
│  Your Application                                        │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  Pooshgan\PasarGuard\PasarGuard                          │
│  ──────────────────────────────                          │
│  High-level facade. Holds 15 endpoint group instances.   │
│  Example: $api->users, $api->nodes, $api->settings       │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  Pooshgan\PasarGuard\Endpoints\* (15 endpoint classes)   │
│  ──────────────────────────────                          │
│  Each class owns a $pathPrefix and exposes typed methods │
│  that map 1:1 to API routes.                             │
│  Example: User::create() -> POST /api/users              │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  Pooshgan\PasarGuard\Client (HTTP layer)                 │
│  ──────────────────────────────                          │
│  Wraps a Guzzle client. Adds Authorization header,       │
│  normalizes subscription path, decodes JSON, and throws  │
│  PasarGuardException on >= 400 responses.                │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  PasarGuard Panel (your self-hosted server)              │
└──────────────────────────────────────────────────────────┘
```

### Key design choices

1. **Single facade.** You always work through `PasarGuard`. No need to instantiate endpoints manually.
2. **Guzzle under the hood.** All advanced Guzzle options (proxy, SSL, timeouts, middlewares) are exposed via the optional `$guzzleOptions` constructor argument.
3. **Predictable signatures.** Every mutating method follows `(string $identifier, array $data = [], array $query = [], array $headers = [])`. Every reading method follows `(array $query = [], array $headers = [])`. This means you can guess the signature of any method you have never used.
4. **By-username / by-id variants.** Most user- and admin-targeted endpoints ship in three flavours: by `username`, `byUsername()`, and `byId()`. Pick whichever identifier you have on hand.

---

## Endpoints

All endpoint groups are accessible as properties on the `PasarGuard` facade:

| Property                | Class                              | Base Path              |
|-------------------------|------------------------------------|------------------------|
| `$api->adminRoles`      | `Endpoints\AdminRole`              | `/api/admin-roles`     |
| `$api->users`           | `Endpoints\User`                   | `/api/users`           |
| `$api->hosts`           | `Endpoints\Host`                   | `/api/hosts`           |
| `$api->groups`          | `Endpoints\Group`                  | `/api/groups`          |
| `$api->hwids`           | `Endpoints\Hwid`                   | `/api/users/{id}/hwids`|
| `$api->setup`           | `Endpoints\Setup`                  | `/api/setup`           |
| `$api->system`          | `Endpoints\System`                 | `/api`                 |
| `$api->cores`           | `Endpoints\Core`                   | `/api/cores`           |
| `$api->nodes`           | `Endpoints\Node`                   | `/api`                 |
| `$api->subscriptions`   | `Endpoints\Subscription`           | `/sub`                 |
| `$api->userTemplates`   | `Endpoints\UserTemplate`           | `/api/user_templates`  |
| `$api->admins`          | `Endpoints\Admin`                  | `/api`                 |
| `$api->settings`        | `Endpoints\Settings`               | `/api/settings`        |
| `$api->clientTemplates` | `Endpoints\ClientTemplate`         | `/api/client_templates`|
| `$api->home`            | `Endpoints\Home`                   | `/api`                 |

---

### Users

The `users` group is the largest endpoint. It manages subscribers, their data limits, expirations, ownership, subscriptions, and bulk operations. Every method that targets a single user ships in three variants — by default `username` slug, `getByUsername()`, and `getById()` — so you can use whichever identifier your application holds.

#### List and search users

```php
// All users (paginated)
$all = $api->users->list();

// Lightweight list (id + username only)
$simple = $api->users->listSimple();

// Filter by query string (?status=active&limit=50)
$active = $api->users->list(['status' => 'active', 'limit' => 50]);

// Users that have already expired
$expired = $api->users->getExpired();
```

#### Get a single user

```php
// By username (default variant)
$u1 = $api->users->get('john_doe');

// Explicit by-username variant
$u2 = $api->users->getByUsername('john_doe');

// By internal user ID
$u3 = $api->users->getById(42);

// Fetch the subscription URL for a specific client type
$sub = $api->users->getSubscriptionById(42, 'v2rayNG');
```

#### Create, update, delete

```php
// Create a single user
$created = $api->users->create([
    'username'    => 'jane_doe',
    'proxies'     => ['vmess' => ['id' => '...']],
    'data_limit'  => 5368709120,        // 5 GB in bytes
    'expire'      => (time() + 86400*30) * 1000,
    'status'      => 'active',
    'data_limit_reset_strategy' => 'no_reset',
]);

// Update by username
$api->users->update('jane_doe', ['data_limit' => 10737418240]);

// Update by id (also via updateByUsername / updateById)
$api->users->updateById(42, ['status' => 'disabled']);

// Delete
$api->users->delete('jane_doe');
$api->users->deleteByUsername('jane_doe');
$api->users->deleteById(42);
```

#### Enable / Disable

```php
$api->users->setDisabled('jane_doe', ['disabled' => true]);   // disable
$api->users->setDisabled('jane_doe', ['disabled' => false]);  // re-enable
$api->users->setDisabledByUsername('jane_doe', ['disabled' => true]);
$api->users->setDisabledById(42, ['disabled' => false]);
```

#### Reset usage & revoke subscription

```php
// Reset data usage of a single user
$api->users->resetDataUsage('jane_doe');
$api->users->resetDataUsageByUsername('jane_doe');
$api->users->resetDataUsageById(42);

// Reset data usage of EVERY user (be careful!)
$api->users->resetAllDataUsage();

// Revoke a user's subscription URL (generates a new one)
$api->users->revokeSubscription('jane_doe');
$api->users->revokeSubscriptionByUsername('jane_doe');
$api->users->revokeSubscriptionById(42);
```

#### Ownership & next-plan activation

```php
// Transfer ownership to admin username "reseller_3"
$api->users->setOwner('jane_doe', ['admin_username' => 'reseller_3']);
$api->users->setOwnerByUsername('jane_doe', ['admin_username' => 'reseller_3']);
$api->users->setOwnerById(42, ['admin_username' => 'reseller_3']);

// Activate the user's queued "next plan"
$api->users->activeNextPlan('jane_doe');
$api->users->activeNextPlanByUsername('jane_doe');
$api->users->activeNextPlanById(42);
```

#### Usage & metrics

```php
// Per-user usage
$usage = $api->users->getUsage('jane_doe');
$usage = $api->users->getUsageByUsername('jane_doe');
$usage = $api->users->getUsageById(42);

// Aggregate usage of all users
$allUsage = $api->users->getAllUsage();

// Counts grouped by a metric ("active", "expired", "limited", ...)
$counts = $api->users->getUsersCountMetric('active');

// Subscription update history (chart + list)
$chart = $api->users->getSubUpdateChart();
$list  = $api->users->getSubUpdateList('jane_doe');
$list  = $api->users->getSubUpdateListByUsername('jane_doe');
$list  = $api->users->getSubUpdateListById(42);
```

#### Expired users

```php
// List expired
$expired = $api->users->getExpired();

// Bulk-delete all expired users
$deleted = $api->users->deleteExpired();
```

#### Bulk operations

All bulk methods accept an array of identifiers (usernames or ids, depending on the variant) and additional payload data.

```php
// Bulk delete / reset / disable / enable / revoke
$api->users->bulkDelete(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkReset(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkDisable(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkEnable(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkRevokeSub(['usernames' => ['a', 'b', 'c']]);

// Bulk change owner
$api->users->bulkSetOwner([
    'usernames' => ['a', 'b'],
    'admin_username' => 'reseller_3',
]);

// Bulk modify expiration / data limit / proxy settings
$api->users->bulkModifyExpire([
    'usernames' => ['a', 'b'],
    'expire'    => (time() + 86400 * 7) * 1000,
]);
$api->users->bulkModifyDataLimit([
    'usernames'  => ['a', 'b'],
    'data_limit' => 10737418240,
]);
$api->users->bulkModifyProxySettings([
    'usernames' => ['a', 'b'],
    'proxies'   => ['vmess' => ['id' => '...']],
]);

// Bulk reallocate WireGuard peer IPs (re-run IPAM for the listed users)
$api->users->bulkReallocateWireguardPeerIps([
    'usernames' => ['a', 'b'],
]);
```

#### Template-based user creation

You can pre-define user templates in the panel and instantiate users from them — great for SaaS-style provisioning.

```php
// Create a single user from a template
$api->users->createFromTemplate([
    'template_id' => 5,
    'username'    => 'from_tpl_1',
    'count'       => 1,
]);

// Bulk-create users from a template (e.g. 100 users)
$api->users->bulkCreateFromTemplate([
    'template_id' => 5,
    'count'       => 100,
    'prefix'      => 'bulk_user_',
]);

// Apply a template's settings to existing users
$api->users->bulkApplyTemplate([
    'template_id' => 5,
    'usernames'   => ['a', 'b', 'c'],
]);

// Update an existing user so it matches a template
$api->users->updateWithTemplate('jane_doe', ['template_id' => 5]);
$api->users->updateWithTemplateByUsername('jane_doe', ['template_id' => 5]);
$api->users->updateWithTemplateById(42, ['template_id' => 5]);
```

---

### Admins

The `admins` group manages resellers and administrators. In addition to the CRUD operations familiar from the `users` group, admins expose a `getToken()` flow (for reseller login) and a `getMiniAppToken()` flow (for Telegram Mini App auth), as well as operations that act on the *users owned by* an admin.

#### Authentication

```php
// Login: returns a bearer token for the admin
$login = $api->admins->getToken([
    'username' => 'reseller_3',
    'password' => 's3cret',
]);
$bearer = $login['access_token'];

// Telegram Mini App login (validateData from Telegram init payload)
$miniApp = $api->admins->getMiniAppToken([
    'init_data' => '<telegram_web_app_init_data>',
]);
```

#### CRUD

```php
// Create a new admin / reseller
$api->admins->create([
    'username'    => 'reseller_4',
    'password'    => 's3cret',
    'is_sudo'     => false,
    'users'       => [],
]);

// Update
$api->admins->update('reseller_4', ['is_sudo' => true]);
$api->admins->updateByUsername('reseller_4', ['password' => 'newpass']);
$api->admins->updateById(7, ['is_sudo' => false]);

// Delete
$api->admins->delete('reseller_4');
$api->admins->deleteByUsername('reseller_4');
$api->admins->deleteById(7);
```

#### List and inspect

```php
$all      = $api->admins->list();
$simple   = $api->admins->listSimple();
$usage    = $api->admins->getUsage('reseller_4');
$usage    = $api->admins->getUsageByUsername('reseller_4');
$usage    = $api->admins->getUsageById(7);
```

#### Acting on an admin's users

```php
// Disable / activate / delete every user owned by an admin
$api->admins->disableUsers('reseller_4');
$api->admins->disableUsersByUsername('reseller_4');
$api->admins->disableUsersById(7);

$api->admins->activateUsers('reseller_4');
$api->admins->activateUsersByUsername('reseller_4');
$api->admins->activateUsersById(7);

$api->admins->deleteUsers('reseller_4');
$api->admins->deleteUsersByUsername('reseller_4');
$api->admins->deleteUsersById(7);

// Reset usage of every user owned by an admin
$api->admins->resetUsage('reseller_4');
$api->admins->resetUsageByUsername('reseller_4');
$api->admins->resetUsageById(7);
```

#### Bulk admin operations

```php
$api->admins->bulkDelete(['usernames' => ['r1', 'r2']]);
$api->admins->bulkReset(['usernames' => ['r1', 'r2']]);
$api->admins->bulkDisable(['usernames' => ['r1', 'r2']]);
$api->admins->bulkEnable(['usernames' => ['r1', 'r2']]);
$api->admins->bulkDisableUsers(['usernames' => ['r1', 'r2']]);
$api->admins->bulkActivateUsers(['usernames' => ['r1', 'r2']]);
$api->admins->bulkDeleteUsers(); // no body — deletes ALL users of EVERY admin
```

---

### Admin Roles

Role-based access control for admins.

```php
// List all roles
$roles = $api->adminRoles->list();
$simple = $api->adminRoles->listSimple();

// Get a role
$role = $api->adminRoles->get(1);

// Create a role
$api->adminRoles->create([
    'name'        => 'Support Agent',
    'permissions' => ['users:read', 'users:reset'],
    'color'       => '#3b82f6',
]);

// Update / delete
$api->adminRoles->update(1, ['name' => 'Senior Support']);
$api->adminRoles->delete(1);
```

---

### Nodes

Nodes represent the actual proxy servers running your cores. The `nodes` group covers CRUD, software / core / geofiles updates, reconnection, sync, logs, and stats.

```php
// Node settings + usage
$settings = $api->nodes->getSettings();
$usage    = $api->nodes->getUsage();
$counts   = $api->nodes->getUserCountMetric('online');

// List
$nodes    = $api->nodes->list();
$simple   = $api->nodes->listSimple();

// Reconnect every node at once
$api->nodes->reconnectAll();

// Create
$api->nodes->create([
    'name'       => 'de-fra-01',
    'address'    => '203.0.113.10',
    'port'       => 62050,
    'api_port'   => 62051,
]);

// Inspect / mutate one node
$node = $api->nodes->get(1);
$api->nodes->update(1, ['name' => 'de-fra-01-renamed']);

// Software / core / geofiles update
$api->nodes->updateNode(1);
$api->nodes->updateCore(1);
$api->nodes->updateGeofiles(1);

// Reset usage, reconnect, sync
$api->nodes->resetUsage(1);
$api->nodes->reconnect(1);
$api->nodes->sync(1, ['force' => true]);

// Logs and periodic stats
$logs  = $api->nodes->getLogs(1, ['limit' => 100]);
$stats = $api->nodes->getStatsPeriodic(1, ['interval' => '1h']);

// Delete
$api->nodes->delete(1);
```

---

### Cores

A "core" is the underlying proxy binary (e.g., Xray, Marzban-node, Sing-box) that a node runs.

```php
// CRUD
$api->cores->create(['name' => 'Xray 1.8.24', 'version' => '1.8.24', 'type' => 'xray']);
$core = $api->cores->get(1);
$api->cores->update(1, ['version' => '1.8.25']);
$api->cores->delete(1);

// List
$all    = $api->cores->list();
$simple = $api->cores->listSimple();

// Restart the core on every node that uses it
$api->cores->restart(1);

// Bulk delete
$api->cores->bulkDelete(['ids' => [1, 2, 3]]);
```

---

### Hosts

Hosts are the public-facing addresses / SNI entries users connect to.

```php
// CRUD
$api->hosts->create([
    'remark' => 'CDN Host',
    'address' => 'cdn.example.com',
    'port' => 443,
    'sni' => 'cdn.example.com',
    'host' => 'cdn.example.com',
    'inbound_tag' => 'V2RAY-NG',
]);
$api->hosts->get(1);
$api->hosts->update(1, ['address' => 'cdn2.example.com']);
$api->hosts->delete(1);

// List / update all / bulk ops
$all = $api->hosts->list();
$api->hosts->updateAll(['mux' => false]);
$api->hosts->bulkDelete(['ids' => [1, 2, 3]]);
$api->hosts->bulkDisable(['ids' => [1, 2, 3]]);
$api->hosts->bulkEnable(['ids' => [1, 2, 3]]);
```

---

### Groups

Groups let you bundle users for collective operations.

```php
$api->groups->create(['name' => 'Premium Users']);
$api->groups->list();
$api->groups->listSimple();
$api->groups->get(1);
$api->groups->update(1, ['name' => 'Premium Plus']);
$api->groups->delete(1);

// Add / remove users
$api->groups->bulkAdd(['group_id' => 1, 'usernames' => ['a', 'b']]);
$api->groups->bulkRemove(['group_id' => 1, 'usernames' => ['a']]);

// Bulk disable / enable
$api->groups->bulkDisable(['ids' => [1, 2]]);
$api->groups->bulkEnable(['ids' => [1, 2]]);
$api->groups->bulkDelete(['ids' => [1, 2]]);
```

---

### HWIDs

Hardware-ID locks for client apps that enforce device binding.

```php
// List HWID locks of a user
$api->hwids->get(42);

// Delete a single HWID lock
$api->hwids->delete(42, 'hwid-string-from-client');

// Reset (clear) all HWID locks for a user
$api->hwids->reset(42, []);
```

---

### Subscriptions

Subscription endpoints are served from `/sub` by default (configurable via the `Client` constructor). These are the URLs that end-users put into their client apps.

```php
// Get the auto-detected subscription content for a token
$api->subscriptions->get('subscription-token-here');

// Informational page (used by the panel's web UI)
$api->subscriptions->getInfo('subscription-token-here');

// Raw subscription (plain-text list of links)
$api->subscriptions->getRaw('subscription-token-here');

// App store / download page links
$api->subscriptions->getApps('subscription-token-here');

// Subscription usage statistics
$api->subscriptions->getUsage('subscription-token-here');

// Subscription content for a SPECIFIC client type (v2rayNG, Streisand, ...)
$api->subscriptions->getWithClientType('subscription-token-here', 'v2rayNG');
```

If your panel exposes subscriptions under a different path (e.g., `/custom-sub`), pass it to the client once:

```php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  '...',
    subscriptionPath: '/custom-sub',
);
```

Every `/sub`-prefixed request from `Subscription` will then automatically use `/custom-sub`.

---

### User Templates

Reusable recipes for creating users with a pre-configured set of proxies, data limits, expirations, and notes.

```php
$api->userTemplates->create([
    'name'       => 'Basic 10GB / 30d',
    'data_limit' => 10737418240,
    'duration'   => 2592000, // seconds
]);
$api->userTemplates->list();
$api->userTemplates->listSimple();
$api->userTemplates->get(1);
$api->userTemplates->update(1, ['name' => 'Basic 20GB / 30d']);
$api->userTemplates->delete(1);

$api->userTemplates->bulkDelete(['ids' => [1, 2]]);
$api->userTemplates->bulkDisable(['ids' => [1, 2]]);
$api->userTemplates->bulkEnable(['ids' => [1, 2]]);
```

---

### Client Templates

Templates that customize what each subscription client (v2rayNG, Streisand, V2RayN, ...) sees — useful for branding, custom configs, or pushing in-app ads.

```php
$api->clientTemplates->create([
    'name'        => 'v2rayNG Default',
    'client_type' => 'v2rayNG',
    'body'        => '<config-template>',
]);
$api->clientTemplates->get(1);
$api->clientTemplates->list();
$api->clientTemplates->listSimple();
$api->clientTemplates->update(1, ['body' => '<updated-template>']);
$api->clientTemplates->delete(1);
$api->clientTemplates->bulkDelete(['ids' => [1, 2]]);
```

---

### Settings

Panel-wide settings (subscription path, Telegram bot, captcha, branding, etc.).

```php
$all      = $api->settings->get();
$general  = $api->settings->getGeneral();

$api->settings->update([
    'telegram_bot_token' => '...',
    'captcha'            => ['enabled' => true, 'site_key' => '...'],
]);
```

---

### System

Server-level stats, inbound info, and worker health — handy for dashboards and uptime monitors.

```php
$system       = $api->system->getStats();        // /api/system
$resources    = $api->system->getResourceStats();// /api/system/resources
$usersStats   = $api->system->getUsersStats();   // /api/system/users
$inbounds     = $api->system->getInbounds();     // /api/inbounds
$inboundDetails = $api->system->getInboundDetails();
$workersHealth  = $api->system->getWorkersHealth();
```

---

### Setup

One-time setup endpoints for creating / upgrading / deleting the panel owner.

```php
// First-run: create the panel owner (sudo admin)
$api->setup->createOwner([
    'username'   => 'root',
    'password'   => '...',
    'telegram_id'=> null,
]);

// Reset the owner's password
$api->setup->resetOwnerPassword(['password' => '...']);

// Upgrade the owner to a higher role (panel migrations)
$api->setup->upgradeOwner(['confirm' => true]);

// Delete the owner entirely (irreversible)
$api->setup->deleteOwner();
```

---

### Home

Health-check endpoint — useful for uptime probes and load-balancer checks.

```php
$health = $api->home->health();
// 200 OK -> {"status":"healthy"} typically
```

---

## Real-World Examples

### 1. Provision 100 users from a template

```php
<?php
require 'vendor/autoload.php';

use Pooshgan\PasarGuard\Client;
use Pooshgan\PasarGuard\PasarGuard;
use Pooshgan\PasarGuard\Exceptions\PasarGuardException;

$client = new Client('https://panel.example.com', getenv('PASARGUARD_TOKEN'));
$api    = new PasarGuard($client);

try {
    $result = $api->users->bulkCreateFromTemplate([
        'template_id' => 5,
        'count'       => 100,
        'prefix'      => 'student_',
        'username_pattern' => 'student_{n}',
    ]);

    printf("Created %d users\n", count($result['created']));
    foreach ($result['created'] as $u) {
        printf(" - %s (link: %s)\n", $u['username'], $u['subscription_url']);
    }
} catch (PasarGuardException $e) {
    fprintf(STDERR, "API error %d: %s\n", $e->getCode(), $e->getMessage());
    fprintf(STDERR, "Payload: %s\n", json_encode($e->getErrorData()));
    exit(1);
}
```

### 2. Daily cron: disable expired users and email a summary

```php
<?php
require 'vendor/autoload.php';

use Pooshgan\PasarGuard\Client;
use Pooshgan\PasarGuard\PasarGuard;

$api = new PasarGuard(new Client('https://panel.example.com', getenv('PASARGUARD_TOKEN')));

$expired = $api->users->getExpired(['limit' => 1000]);
$usernames = array_column($expired, 'username');

if (!empty($usernames)) {
    $api->users->bulkDisable(['usernames' => $usernames]);
}

mail(
    'ops@example.com',
    'PasarGuard Daily Report',
    sprintf('Disabled %d expired users.', count($usernames))
);
```

### 3. Telegram Mini App: authenticate an admin

```php
<?php
// Telegram Web App sends init_data in the URL fragment or Authorization header.
$initData = $_SERVER['HTTP_X_TELEGRAM_INIT_DATA'] ?? '';

$client = new Client('https://panel.example.com', ''); // no bearer needed for this route
$api    = new PasarGuard($client);

$resp = $api->admins->getMiniAppToken(['init_data' => $initData]);
$token = $resp['access_token']; // use this for subsequent calls as the admin

// Now make a real client with this admin token
$adminApi = new PasarGuard(
    new Client('https://panel.example.com', $token)
);

$me = $adminApi->admins->listSimple();
print_r($me);
```

### 4. Custom HTTP layer (proxy + extended timeout)

```php
<?php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  getenv('PASARGUARD_TOKEN'),
    guzzleOptions: [
        'proxy' => 'http://corporate-proxy.local:8080',
        'timeout' => 60,
        'verify'  => false,        // skip SSL verify (e.g., self-signed)
        'headers' => [
            'X-Request-Source' => 'internal-cron',
        ],
    ],
);
$api = new PasarGuard($client);
$users = $api->users->list(['limit' => 500]);
```

### 5. Per-request custom header (e.g., Telegram Mini App auth on a single call)

```php
$api->users->list(
    [], // no query
    [
        'X-Telegram-Init-Data' => '<init_data_string>',
        'X-Admin-Username'     => 'reseller_3',
    ]
);
```

---

## Error Handling

Every non-2xx response throws a single, predictable exception:

```php
use Pooshgan\PasarGuard\Exceptions\PasarGuardException;

try {
    $api->users->get('non_existent_user');
} catch (PasarGuardException $e) {
    echo $e->getMessage();        // "User not found" (server-provided detail)
    echo $e->getCode();           // 404 (HTTP status)
    print_r($e->getErrorData());  // full decoded JSON body from the server
}
```

| HTTP Status | Cause                                                   |
|-------------|---------------------------------------------------------|
| `400`       | Malformed payload / validation error                    |
| `401`       | Missing or invalid bearer token                         |
| `403`       | Authenticated but not permitted (insufficient role)     |
| `404`       | Entity (user / node / core / ...) not found             |
| `409`       | Conflict (e.g., username already taken)                 |
| `422`       | Semantically invalid request                            |
| `429`       | Rate limit hit — back off and retry                     |
| `5xx`       | Server-side error — retry with exponential backoff      |

### Retry helper example

```php
function withRetry(callable $fn, int $maxAttempts = 3): array {
    $attempt = 0;
    while (true) {
        $attempt++;
        try {
            return $fn();
        } catch (PasarGuardException $e) {
            if ($attempt >= $maxAttempts || $e->getCode() < 500 && $e->getCode() !== 429) {
                throw $e;
            }
            usleep(500_000 * (2 ** ($attempt - 1))); // 0.5s, 1s, 2s, ...
        }
    }
}

$users = withRetry(fn () => $api->users->list());
```

---

## Advanced Usage

### Sharing a single SDK instance across long-running workers

The SDK is stateless per request. You can build one `PasarGuard` instance at worker bootstrap and reuse it for thousands of jobs:

```php
// worker bootstrap (RoadRunner / Swoole / FrankenPHP)
$api = new PasarGuard(new Client(/* ... */));

while ($job = $queue->consume()) {
    $api->users->resetDataUsage($job['username']);
}
```

### Injecting custom Guzzle middlewares

Because the SDK never hides Guzzle, you can attach any middleware by passing a pre-built `GuzzleClient` instance to a custom subclass of `Client`, or by manipulating the handler stack through `guzzleOptions`. For most use-cases, the constructor options are enough:

```php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  '...',
    guzzleOptions: [
        'connect_timeout' => 5,
        'timeout'         => 30,
        'http_errors'     => false, // already false by default
        'debug'           => fopen('php://stderr', 'w'),
    ],
);
```

### Using multiple panels at once

```php
$panelA = new PasarGuard(new Client('https://panel-a.example.com', $tokenA));
$panelB = new PasarGuard(new Client('https://panel-b.example.com', $tokenB));

$usersA = $panelA->users->list();
$usersB = $panelB->users->list();
```

### Non-default subscription path

```php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  '...',
    subscriptionPath: '/custom-sub',
);

$api = new PasarGuard($client);
$api->subscriptions->get('token'); // GET /custom-sub/token
```

### Sending form params instead of JSON

Most mutating methods send JSON. For the few routes that expect form-encoded bodies (e.g., admin login), the SDK already uses `form_params`. For custom cases, you can pass a raw Guzzle `multipart` or `form_params` option through the `headers` / `query` slots — or, more cleanly, extend the endpoint:

```php
class CustomUser extends \Pooshgan\PasarGuard\Endpoints\User {
    public function createForm(array $formData): array {
        return $this->client->request('POST', $this->pathPrefix, [
            'form_params' => $formData,
        ]);
    }
}
```

---

## API Reference

### `Client`

```php
public function __construct(
    string $baseUrl,
    string $token,
    string $subscriptionPath = '/sub',
    array  $guzzleOptions   = [],
)
```

| Parameter           | Type     | Description |
|---------------------|----------|-------------|
| `baseUrl`           | `string` | Panel root URL, e.g. `https://panel.example.com`. Trailing slash is trimmed. |
| `token`             | `string` | Bearer token used in the `Authorization` header. |
| `subscriptionPath`  | `string` | Path prefix for subscription endpoints. Defaults to `/sub`. |
| `guzzleOptions`     | `array`  | Any options accepted by `GuzzleHttp\Client` constructor (proxy, timeout, verify, etc.). |

#### `Client::request()`

```php
public function request(string $method, string $uri, array $options = []): array
```

Performs an HTTP request and returns the decoded JSON payload as an array. Throws `PasarGuardException` on any non-2xx response.

### `PasarGuard`

A facade holding 15 endpoint instances. Construct it with a `Client`:

```php
public function __construct(Client $client)
```

### Endpoint method signature conventions

Every endpoint method follows one of three canonical shapes:

```php
// Read (no body, optional query + headers)
public function list(array $query = [], array $headers = []): array;

// Mutate (JSON body, optional query + headers)
public function create(array $data = [], array $query = [], array $headers = []): array;

// Mutate with identifier
public function update(string $id, array $data = [], array $query = [], array $headers = []): array;
```

### `PasarGuardException`

```php
public function getMessage(): string;       // server-provided detail
public function getCode(): int;             // HTTP status code
public function getErrorData(): array;      // decoded JSON error body
```

---

## Credits

- **Original Panel**: [PasarGuard](https://github.com/PasarGuard/panel)
- **SDK Author**: [Kazem Pooshgan](https://github.com/pooshgan)
- **HTTP Foundation**: [GuzzleHTTP](https://github.com/guzzle/guzzle)

---

## License

This project is licensed under the [MIT License](LICENSE).

Copyright (c) 2026 Kazem Pooshgan
