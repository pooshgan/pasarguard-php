# PasarGuard PHP SDK

<div align="center">

![PHP](https://img.shields.io/badge/PHP-%3E%3D8.1-blue.svg?style=flat-square&logo=php)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)
![Packagist](https://img.shields.io/packagist/v/pooshgan/pasarguard-php.svg?style=flat-square)
![Coverage](https://img.shields.io/badge/API_Coverage-100%25-brightgreen.svg?style=flat-square)

**یک SDK کامل، تایپ‌شده و آماده تولید برای [PasarGuard Panel](https://github.com/PasarGuard/panel) API.**

[نصب](#installation) •
[شروع سریع](#quick-start) •
[Endpointها](#endpoints) •
[مثال‌ها](#real-world-examples) •
[مدیریت خطا](#error-handling) •
[پیشرفته](#advanced-usage)

📖 [English README](README.md) | 📖 [فارسی](README.fa.md)

</div>

---

## فهرست مطالب

- [بررسی کلی](#overview)
- [ویژگی‌ها](#features)
- [نیازمندی‌ها](#requirements)
- [نصب](#installation)
- [شروع سریع](#quick-start)
- [معماری](#architecture)
- [Endpointها](#endpoints)
  - [کاربران](#users)
  - [ادمین‌ها](#admins)
  - [نقش‌های ادمین](#admin-roles)
  - [نودها](#nodes)
  - [هسته‌ها](#cores)
  - [هاست‌ها](#hosts)
  - [گروه‌ها](#groups)
  - [HWIDها](#hwids)
  - [اشتراک‌ها](#subscriptions)
  - [قالب‌های کاربر](#user-templates)
  - [قالب‌های کلاینت](#client-templates)
  - [تنظیمات](#settings)
  - [سیستم](#system)
  - [راه‌اندازی](#setup)
  - [خانه](#home)
- [مثال‌های دنیای واقعی](#real-world-examples)
- [مدیریت خطا](#error-handling)
- [استفاده پیشرفته](#advanced-usage)
- [مرجع API](#api-reference)
- [اعتبارات](#credits)
- [مجوز](#license)

---

## Overview

**PasarGuard PHP SDK** یک کتابخانه کلاینت کاملاً تایپ‌شده و ارگونومیک برای تعامل با PasarGuard Panel API است. این SDK بر پایه [GuzzleHTTP](https://github.com/guzzle/guzzle) ساخته شده و از کنوانسیون‌های مدرن PHP 8.1+ شامل تایپینگ سخت‌گیرانه، PSR-4 autoloading و امضاهای روش قابل پیش‌بینی پیروی می‌کند.

این SDK **۱۰۰٪ سطح API پاسارگارد** را پوشش می‌دهد و هر endpoint (کاربران، نودها، هسته‌ها، ادمین‌ها، هاست‌ها، گروه‌ها، اشتراک‌ها، قالب‌ها، تنظیمات، آمار سیستم، مدیریت HWID و بیشتر) را از طریق یک رابط شی‌گرا، تمیز و زنجیره‌ای در دسترس قرار می‌دهد. هر روش ۱:۱ به یک مسیر API نگاشت می‌شود، با پارامترهایی که به شدت تایپ شده‌اند و payloadهای درخواست به آرایه‌های PHP نرمال‌سازی می‌شوند.

چه در حال ساخت یک داشبورد سفارشی، خودکارسازی تأمین کاربر، ادغام صورتحساب، یا اجرای یک Telegram Mini App با پشتیبانی پاسارگارد باشید، این SDK یک پایه پایدار بدون سربار فراخوانی‌های خام HTTP به شما می‌دهد.

---

## Features

- **تایپ‌شده قوی** — هر روش endpoint دارای انواع پارامتر صریح است و یک `array` تایپ‌شده برمی‌گرداند. بدون جادو، بدون غافلگیری.
- **قدرت گرفته از Guzzle** — ساخته شده بر پایه Guzzle 7، استاندارد واقعی HTTP تولیدی در PHP. پشتیبانی از middlewareها، فراخوانی‌های ناهمزمان، handlerهای سفارشی و connection pooling به صورت بومی.
- **پوشش ۱۰۰٪ API** — هر endpoint که توسط PasarGuard Panel REST API منتشر می‌شود را پیاده‌سازی می‌کند، شامل عملیات دسته‌ای، واریانت‌های by-username / by-id، و flowهای مدیریت کاربر ادمین.
- **احراز هویت انعطاف‌پذیر** — احراز هویت Bearer token بومی، به علاوه پشتیبانی کامل برای تزریق headerهای سفارشی در هر درخواست (مثلاً احراز هویت Telegram Mini App).
- **مسیر اشتراک قابل پیکربندی** — اگر پنل شما از یک مسیر اشتراک غیر پیش‌فرض استفاده می‌کند (مثلاً `/sub` در مقابل `/custom-sub`)، آن را یک بار به constructor `Client` منتقل کنید و هر endpoint مرتبط به طور خودکار بازنویسی می‌شود.
- **مدیریت خطای سازگار** — همه پاسخ‌های غیر 2xx یک `PasarGuardException` واحد با کد وضعیت HTTP و payload خطای خام ایجاد می‌کنند، بنابراین می‌توانید تلاش مجدد، لاگ‌گیری و پیام‌های面向 کاربر را متمرکز کنید.
- **PSR-4 Autoloading** — `composer install` و آماده هستید. بدون include دستی، بدون زنجیره‌های `require_once`.
- **بدون State پنهان** — SDK در هر فراخوانی stateless است؛ ایمن برای اشتراک‌گذاری یک نمونه `PasarGuard` در یک فرآیند طولانی‌مدت (queue workers، daemonها، Swoole handlers).
- **عملیات دسته‌ای** — پشتیبانی درجه اول برای عملیات حذف / ریست / غیرفعال / فعال / set-owner / modify-expire / modify-data-limit / modify-proxy-settings / wireguard-reallocate روی کاربران، ادمین‌ها، هاست‌ها، گروه‌ها و قالب‌ها.

---

## Requirements

| نیازمندی | نسخه |
|-------------|---------|
| PHP         | `>= 8.1` |
| GuzzleHTTP  | `^7.0`  |
| ext-json    | bundled |
| ext-curl    | توصیه می‌شود (handler پیش‌فرض Guzzle) |

این SDK فریم‌ورک-agnostic است: به خوبی در داخل Laravel، Symfony، Yii، CodeIgniter، CakePHP، اسکریپت‌های ساده PHP، یا workerهای طولانی‌مدت (RoadRunner، Swoole، FrankenPHP) کار می‌کند.

---

## Installation

نصب از طریق Composer:

```bash
composer require pooshgan/pasarguard-php
```

اگر هنوز Composer ندارید:

```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar require pooshgan/pasarguard-php
```

پس از نصب، autoloader کامپوزر را در فایل entry-point خود شامل کنید:

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

// 1. راه‌اندازی کلاینت HTTP با URL پنل و توکن ادمین
$client = new Client(
    baseUrl: 'https://your-panel-domain.com',
    token:  'your-admin-bearer-token'
);

// 2. آن را با facade سطح بالای SDK بپیچید
$api = new PasarGuard($client);

// 3. هر گروه endpoint را به عنوان property صدا بزنید
$users = $api->users->list();
print_r($users);

// 4. یک کاربر جدید با محدودیت داده 1 گیگابایت بسازید
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

SDK عمداً کوچک است و از یک طراحی لایه‌ای پیروی می‌کند:

```
┌──────────────────────────────────────────────────────────┐
│  برنامه شما                                              │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  Pooshgan\PasarGuard\PasarGuard                          │
│  ──────────────────────────────                          │
│  Facade سطح بالا. 15 نمونه گروه endpoint را نگه می‌دارد.   │
│  مثال: $api->users, $api->nodes, $api->settings       │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  Pooshgan\PasarGuard\Endpoints\* (15 کلاس endpoint)      │
│  ──────────────────────────────                          │
│  هر کلاس یک $pathPrefix دارد و روش‌های تایپ‌شده را نمایش  │
│  می‌دهد که 1:1 به مسیرهای API نگاشت می‌شوند.              │
│  مثال: User::create() -> POST /api/users              │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  Pooshgan\PasarGuard\Client (لایه HTTP)                  │
│  ──────────────────────────────                          │
│  یک کلاینت Guzzle را می‌پیچد. Authorization header اضافه  │
│  می‌کند، مسیر اشتراک را نرمال‌سازی می‌کند، JSON decode    │
│  می‌کند و در پاسخ‌های >= 400 یک PasarGuardException      │
│  پرتاب می‌کند.                                            │
└──────────────────────────────────────────────────────────┘
                          │
                          ▼
┌──────────────────────────────────────────────────────────┐
│  PasarGuard Panel (سرور self-hosted شما)                 │
└──────────────────────────────────────────────────────────┘
```

### انتخاب‌های کلیدی طراحی

1. **Facade واحد.** شما همیشه از طریق `PasarGuard` کار می‌کنید. نیازی به نمونه‌سازی دستی endpointها نیست.
2. **Guzzle زیر کاپوت.** تمام گزینه‌های پیشرفته Guzzle (proxy، SSL، timeoutها، middlewareها) از طریق آرگومان اختیاری constructor `$guzzleOptions` در معرض دید قرار می‌گیرند.
3. **امضاهای قابل پیش‌بینی.** هر روش mutating از `(string $identifier, array $data = [], array $query = [], array $headers = [])` پیروی می‌کند. هر روش reading از `(array $query = [], array $headers = [])` پیروی می‌کند. این بدان معناست که می‌توانید امضای هر روشی را که هرگز استفاده نکرده‌اید حدس بزنید.
4. **واریانت‌های By-username / by-id.** بیشتر endpointهای هدف کاربر و ادمین در سه طعم عرضه می‌شوند: توسط `username`، `byUsername()`، و `byId()`. هر شناسه‌ای که در دست دارید را انتخاب کنید.

---

## Endpoints

همه گروه‌های endpoint به عنوان property روی facade `PasarGuard` در دسترس هستند:

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

گروه `users` بزرگترین endpoint است. مشترکین، محدودیت‌های داده، انقضاها، مالکیت، اشتراک‌ها و عملیات دسته‌ای را مدیریت می‌کند. هر روشی که یک کاربر واحد را هدف قرار می‌دهد در سه واریانت عرضه می‌شود — توسط `username` slug پیش‌فرض، `getByUsername()`، و `getById()` — بنابراین می‌توانید از هر شناسه‌ای که برنامه شما نگه می‌دارد استفاده کنید.

#### لیست و جستجوی کاربران

```php
// همه کاربران (صفحه‌بندی شده)
$all = $api->users->list();

// لیست سبک (فقط id + username)
$simple = $api->users->listSimple();

// فیلتر بر اساس query string (?status=active&limit=50)
$active = $api->users->list(['status' => 'active', 'limit' => 50]);

// کاربرانی که قبلاً منقضی شده‌اند
$expired = $api->users->getExpired();
```

#### دریافت یک کاربر واحد

```php
// بر اساس username (واریانت پیش‌فرض)
$u1 = $api->users->get('john_doe');

// واریانت صریح by-username
$u2 = $api->users->getByUsername('john_doe');

// بر اساس ID داخلی کاربر
$u3 = $api->users->getById(42);

// دریافت URL اشتراک برای یک نوع کلاینت خاص
$sub = $api->users->getSubscriptionById(42, 'v2rayNG');
```

#### ایجاد، به‌روزرسانی، حذف

```php
// ایجاد یک کاربر واحد
$created = $api->users->create([
    'username'    => 'jane_doe',
    'proxies'     => ['vmess' => ['id' => '...']],
    'data_limit'  => 5368709120,        // 5 GB به bytes
    'expire'      => (time() + 86400*30) * 1000,
    'status'      => 'active',
    'data_limit_reset_strategy' => 'no_reset',
]);

// به‌روزرسانی بر اساس username
$api->users->update('jane_doe', ['data_limit' => 10737418240]);

// به‌روزرسانی بر اساس id (همچنین از طریق updateByUsername / updateById)
$api->users->updateById(42, ['status' => 'disabled']);

// حذف
$api->users->delete('jane_doe');
$api->users->deleteByUsername('jane_doe');
$api->users->deleteById(42);
```

#### فعال / غیرفعال

```php
$api->users->setDisabled('jane_doe', ['disabled' => true]);   // غیرفعال
$api->users->setDisabled('jane_doe', ['disabled' => false]);  // فعال مجدد
$api->users->setDisabledByUsername('jane_doe', ['disabled' => true]);
$api->users->setDisabledById(42, ['disabled' => false]);
```

#### ریست مصرف و لغو اشتراک

```php
// ریست مصرف داده یک کاربر واحد
$api->users->resetDataUsage('jane_doe');
$api->users->resetDataUsageByUsername('jane_doe');
$api->users->resetDataUsageById(42);

// ریست مصرف داده ALL کاربران (مراقب باشید!)
$api->users->resetAllDataUsage();

// لغو URL اشتراک کاربر (یک مورد جدید تولید می‌کند)
$api->users->revokeSubscription('jane_doe');
$api->users->revokeSubscriptionByUsername('jane_doe');
$api->users->revokeSubscriptionById(42);
```

#### مالکیت و فعال‌سازی next-plan

```php
// انتقال مالکیت به admin username "reseller_3"
$api->users->setOwner('jane_doe', ['admin_username' => 'reseller_3']);
$api->users->setOwnerByUsername('jane_doe', ['admin_username' => 'reseller_3']);
$api->users->setOwnerById(42, ['admin_username' => 'reseller_3']);

// فعال کردن "next plan" صف‌بندی شده کاربر
$api->users->activeNextPlan('jane_doe');
$api->users->activeNextPlanByUsername('jane_doe');
$api->users->activeNextPlanById(42);
```

#### مصرف و معیارها

```php
// مصرف per-user
$usage = $api->users->getUsage('jane_doe');
$usage = $api->users->getUsageByUsername('jane_doe');
$usage = $api->users->getUsageById(42);

// مصرف تجمعی همه کاربران
$allUsage = $api->users->getAllUsage();

// شمارش‌ها گروه‌بندی شده بر اساس یک معیار ("active", "expired", "limited", ...)
$counts = $api->users->getUsersCountMetric('active');

// تاریخچه به‌روزرسانی اشتراک (chart + list)
$chart = $api->users->getSubUpdateChart();
$list  = $api->users->getSubUpdateList('jane_doe');
$list  = $api->users->getSubUpdateListByUsername('jane_doe');
$list  = $api->users->getSubUpdateListById(42);
```

#### کاربران منقضی شده

```php
// لیست منقضی شده‌ها
$expired = $api->users->getExpired();

// حذف دسته‌ای همه کاربران منقضی شده
$deleted = $api->users->deleteExpired();
```

#### عملیات دسته‌ای

همه روش‌های bulk یک آرایه از شناسه‌ها (usernameها یا idها، بسته به واریانت) و داده payload اضافی می‌پذیرند.

```php
// حذف دسته‌ای / ریست / غیرفعال / فعال / لغو
$api->users->bulkDelete(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkReset(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkDisable(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkEnable(['usernames' => ['a', 'b', 'c']]);
$api->users->bulkRevokeSub(['usernames' => ['a', 'b', 'c']]);

// تغییر مالک دسته‌ای
$api->users->bulkSetOwner([
    'usernames' => ['a', 'b'],
    'admin_username' => 'reseller_3',
]);

// تغییر انقضا / محدودیت داده / تنظیمات proxy دسته‌ای
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

// تخصیص مجدد IPهای peer WireGuard دسته‌ای (اجرای مجدد IPAM برای کاربران لیست شده)
$api->users->bulkReallocateWireguardPeerIps([
    'usernames' => ['a', 'b'],
]);
```

#### ایجاد کاربر مبتنی بر قالب

می‌توانید قالب‌های کاربر را در پنل از قبل تعریف کنید و کاربران را از آن‌ها نمونه‌سازی کنید — عالی برای تأمین سبک SaaS.

```php
// ایجاد یک کاربر واحد از یک قالب
$api->users->createFromTemplate([
    'template_id' => 5,
    'username'    => 'from_tpl_1',
    'count'       => 1,
]);

// ایجاد دسته‌ای کاربران از یک قالب (مثلاً 100 کاربر)
$api->users->bulkCreateFromTemplate([
    'template_id' => 5,
    'count'       => 100,
    'prefix'      => 'bulk_user_',
]);

// اعمال تنظیمات یک قالب روی کاربران موجود
$api->users->bulkApplyTemplate([
    'template_id' => 5,
    'usernames'   => ['a', 'b', 'c'],
]);

// به‌روزرسانی یک کاربر موجود تا با یک قالب مطابقت داشته باشد
$api->users->updateWithTemplate('jane_doe', ['template_id' => 5]);
$api->users->updateWithTemplateByUsername('jane_doe', ['template_id' => 5]);
$api->users->updateWithTemplateById(42, ['template_id' => 5]);
```

---

### Admins

گروه `admins` resellerها و administrators را مدیریت می‌کند. علاوه بر عملیات CRUD آشنا از گروه `users`، ادمین‌ها یک flow `getToken()` (برای ورود reseller) و یک flow `getMiniAppToken()` (برای احراز هویت Telegram Mini App)، و همچنین عملیاتی که روی *کاربران متعلق به* یک ادمین عمل می‌کنند را نمایش می‌دهند.

#### احراز هویت

```php
// ورود: یک bearer token برای ادمین برمی‌گرداند
$login = $api->admins->getToken([
    'username' => 'reseller_3',
    'password' => 's3cret',
]);
$bearer = $login['access_token'];

// ورود Telegram Mini App (validateData از payload init تلگرام)
$miniApp = $api->admins->getMiniAppToken([
    'init_data' => '<telegram_web_app_init_data>',
]);
```

#### CRUD

```php
// ایجاد یک ادمین / reseller جدید
$api->admins->create([
    'username'    => 'reseller_4',
    'password'    => 's3cret',
    'is_sudo'     => false,
    'users'       => [],
]);

// به‌روزرسانی
$api->admins->update('reseller_4', ['is_sudo' => true]);
$api->admins->updateByUsername('reseller_4', ['password' => 'newpass']);
$api->admins->updateById(7, ['is_sudo' => false]);

// حذف
$api->admins->delete('reseller_4');
$api->admins->deleteByUsername('reseller_4');
$api->admins->deleteById(7);
```

#### لیست و بررسی

```php
$all      = $api->admins->list();
$simple   = $api->admins->listSimple();
$usage    = $api->admins->getUsage('reseller_4');
$usage    = $api->admins->getUsageByUsername('reseller_4');
$usage    = $api->admins->getUsageById(7);
```

#### عمل روی کاربران یک ادمین

```php
// غیرفعال / فعال / حذف هر کاربر متعلق به یک ادمین
$api->admins->disableUsers('reseller_4');
$api->admins->disableUsersByUsername('reseller_4');
$api->admins->disableUsersById(7);

$api->admins->activateUsers('reseller_4');
$api->admins->activateUsersByUsername('reseller_4');
$api->admins->activateUsersById(7);

$api->admins->deleteUsers('reseller_4');
$api->admins->deleteUsersByUsername('reseller_4');
$api->admins->deleteUsersById(7);

// ریست مصرف هر کاربر متعلق به یک ادمین
$api->admins->resetUsage('reseller_4');
$api->admins->resetUsageByUsername('reseller_4');
$api->admins->resetUsageById(7);
```

#### عملیات دسته‌ای ادمین

```php
$api->admins->bulkDelete(['usernames' => ['r1', 'r2']]);
$api->admins->bulkReset(['usernames' => ['r1', 'r2']]);
$api->admins->bulkDisable(['usernames' => ['r1', 'r2']]);
$api->admins->bulkEnable(['usernames' => ['r1', 'r2']]);
$api->admins->bulkDisableUsers(['usernames' => ['r1', 'r2']]);
$api->admins->bulkActivateUsers(['usernames' => ['r1', 'r2']]);
$api->admins->bulkDeleteUsers(); // بدون body — ALL کاربران EVERY ادمین را حذف می‌کند
```

---

### Admin Roles

کنترل دسترسی مبتنی بر نقش برای ادمین‌ها.

```php
// لیست همه نقش‌ها
$roles = $api->adminRoles->list();
$simple = $api->adminRoles->listSimple();

// دریافت یک نقش
$role = $api->adminRoles->get(1);

// ایجاد یک نقش
$api->adminRoles->create([
    'name'        => 'Support Agent',
    'permissions' => ['users:read', 'users:reset'],
    'color'       => '#3b82f6',
]);

// به‌روزرسانی / حذف
$api->adminRoles->update(1, ['name' => 'Senior Support']);
$api->adminRoles->delete(1);
```

---

### Nodes

نودها سرورهای proxy واقعی را نشان می‌دهند که هسته‌های شما را اجرا می‌کنند. گروه `nodes` CRUD، به‌روزرسانی‌های نرم‌افزار / هسته / geofiles، اتصال مجدد، همگام‌سازی، لاگ‌ها و آمار را پوشش می‌دهد.

```php
// تنظیمات نود + مصرف
$settings = $api->nodes->getSettings();
$usage    = $api->nodes->getUsage();
$counts   = $api->nodes->getUserCountMetric('online');

// لیست
$nodes    = $api->nodes->list();
$simple   = $api->nodes->listSimple();

// اتصال مجدد هر نود به صورت یکجا
$api->nodes->reconnectAll();

// ایجاد
$api->nodes->create([
    'name'       => 'de-fra-01',
    'address'    => '203.0.113.10',
    'port'       => 62050,
    'api_port'   => 62051,
]);

// بررسی / تغییر یک نود
$node = $api->nodes->get(1);
$api->nodes->update(1, ['name' => 'de-fra-01-renamed']);

// به‌روزرسانی نرم‌افزار / هسته / geofiles
$api->nodes->updateNode(1);
$api->nodes->updateCore(1);
$api->nodes->updateGeofiles(1);

// ریست مصرف، اتصال مجدد، همگام‌سازی
$api->nodes->resetUsage(1);
$api->nodes->reconnect(1);
$api->nodes->sync(1, ['force' => true]);

// لاگ‌ها و آمار دوره‌ای
$logs  = $api->nodes->getLogs(1, ['limit' => 100]);
$stats = $api->nodes->getStatsPeriodic(1, ['interval' => '1h']);

// حذف
$api->nodes->delete(1);
```

---

### Cores

یک "core" باینری proxy زیرین (مثلاً Xray، Marzban-node، Sing-box) است که یک نود اجرا می‌کند.

```php
// CRUD
$api->cores->create(['name' => 'Xray 1.8.24', 'version' => '1.8.24', 'type' => 'xray']);
$core = $api->cores->get(1);
$api->cores->update(1, ['version' => '1.8.25']);
$api->cores->delete(1);

// لیست
$all    = $api->cores->list();
$simple = $api->cores->listSimple();

// راه‌اندازی مجدد core روی هر نودی که از آن استفاده می‌کند
$api->cores->restart(1);

// حذف دسته‌ای
$api->cores->bulkDelete(['ids' => [1, 2, 3]]);
```

---

### Hosts

هاست‌ها آدرس‌های عمومی-facing / ورودی‌های SNI هستند که کاربران به آن‌ها متصل می‌شوند.

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

// لیست / به‌روزرسانی همه / عملیات دسته‌ای
$all = $api->hosts->list();
$api->hosts->updateAll(['mux' => false]);
$api->hosts->bulkDelete(['ids' => [1, 2, 3]]);
$api->hosts->bulkDisable(['ids' => [1, 2, 3]]);
$api->hosts->bulkEnable(['ids' => [1, 2, 3]]);
```

---

### Groups

گروه‌ها به شما اجازه می‌دهند کاربران را برای عملیات دسته‌ای دسته‌بندی کنید.

```php
$api->groups->create(['name' => 'Premium Users']);
$api->groups->list();
$api->groups->listSimple();
$api->groups->get(1);
$api->groups->update(1, ['name' => 'Premium Plus']);
$api->groups->delete(1);

// افزودن / حذف کاربران
$api->groups->bulkAdd(['group_id' => 1, 'usernames' => ['a', 'b']]);
$api->groups->bulkRemove(['group_id' => 1, 'usernames' => ['a']]);

// غیرفعال / فعال دسته‌ای
$api->groups->bulkDisable(['ids' => [1, 2]]);
$api->groups->bulkEnable(['ids' => [1, 2]]);
$api->groups->bulkDelete(['ids' => [1, 2]]);
```

---

### HWIDs

قفل‌های Hardware-ID برای اپلیکیشن‌های کلاینت که binding دستگاه را اعمال می‌کنند.

```php
// لیست قفل‌های HWID یک کاربر
$api->hwids->get(42);

// حذف یک قفل HWID واحد
$api->hwids->delete(42, 'hwid-string-from-client');

// ریست (پاک کردن) همه قفل‌های HWID برای یک کاربر
$api->hwids->reset(42, []);
```

---

### Subscriptions

endpointهای اشتراک به صورت پیش‌فرض از `/sub` سرو می‌شوند (از طریق constructor `Client` قابل پیکربندی). این‌ها URLهایی هستند که end-users در اپلیکیشن‌های کلاینت خود قرار می‌دهند.

```php
// دریافت محتوای اشتراک auto-detected برای یک token
$api->subscriptions->get('subscription-token-here');

// صفحه اطلاعاتی (استفاده شده توسط web UI پنل)
$api->subscriptions->getInfo('subscription-token-here');

// اشتراک خام (لیست plain-text لینک‌ها)
$api->subscriptions->getRaw('subscription-token-here');

// لینک‌های صفحه app store / دانلود
$api->subscriptions->getApps('subscription-token-here');

// آمار مصرف اشتراک
$api->subscriptions->getUsage('subscription-token-here');

// محتوای اشتراک برای یک نوع کلاینت SPECIFIC (v2rayNG، Streisand، ...)
$api->subscriptions->getWithClientType('subscription-token-here', 'v2rayNG');
```

اگر پنل شما اشتراک‌ها را تحت یک مسیر متفاوت نمایش می‌دهد (مثلاً `/custom-sub`)، آن را یک بار به کلاینت منتقل کنید:

```php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  '...',
    subscriptionPath: '/custom-sub',
);
```

هر درخواست `/sub`-prefixed از `Subscription` سپس به طور خودکار از `/custom-sub` استفاده خواهد کرد.

---

### User Templates

دستورالعمل‌های قابل استفاده مجدد برای ایجاد کاربران با مجموعه‌ای از پیش پیکربندی شده از proxyها، محدودیت‌های داده، انقضاها و یادداشت‌ها.

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

قالب‌هایی که آنچه هر کلاینت اشتراک (v2rayNG، Streisand، V2RayN، ...) می‌بیند را سفارشی می‌کنند — مفید برای branding، configهای سفارشی، یا pushing in-app ads.

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

تنظیمات سطح پنل (مسیر اشتراک، ربات تلگرام، captcha، branding و غیره).

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

آمار سطح سرور، اطلاعات inbound، و سلامت worker — مناسب برای داشبوردها و مانیتورهای uptime.

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

endpointهای راه‌اندازی یک‌باره برای ایجاد / ارتقا / حذف owner پنل.

```php
// First-run: ایجاد owner پنل (sudo admin)
$api->setup->createOwner([
    'username'   => 'root',
    'password'   => '...',
    'telegram_id'=> null,
]);

// ریست پسورد owner
$api->setup->resetOwnerPassword(['password' => '...']);

// ارتقای owner به یک نقش بالاتر (migrationهای پنل)
$api->setup->upgradeOwner(['confirm' => true]);

// حذف کامل owner (برگشت‌ناپذیر)
$api->setup->deleteOwner();
```

---

### Home

endpoint بررسی سلامت — مفید برای probeهای uptime و بررسی‌های load-balancer.

```php
$health = $api->home->health();
// 200 OK -> {"status":"healthy"} معمولاً
```

---

## Real-World Examples

### 1. تأمین 100 کاربر از یک قالب

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

### 2. Cron روزانه: غیرفعال کردن کاربران منقضی شده و ارسال خلاصه ایمیل

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

### 3. Telegram Mini App: احراز هویت یک ادمین

```php
<?php
// Telegram Web App init_data را در URL fragment یا Authorization header ارسال می‌کند.
$initData = $_SERVER['HTTP_X_TELEGRAM_INIT_DATA'] ?? '';

$client = new Client('https://panel.example.com', ''); // بدون bearer مورد نیاز برای این route
$api    = new PasarGuard($client);

$resp = $api->admins->getMiniAppToken(['init_data' => $initData]);
$token = $resp['access_token']; // استفاده از این برای تماس‌های بعدی به عنوان ادمین

// اکنون یک کلاینت واقعی با این توکن ادمین بسازید
$adminApi = new PasarGuard(
    new Client('https://panel.example.com', $token)
);

$me = $adminApi->admins->listSimple();
print_r($me);
```

### 4. لایه HTTP سفارشی (proxy + timeout تمدید شده)

```php
<?php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  getenv('PASARGUARD_TOKEN'),
    guzzleOptions: [
        'proxy' => 'http://corporate-proxy.local:8080',
        'timeout' => 60,
        'verify'  => false,        // رد کردن SSL verify (مثلاً، self-signed)
        'headers' => [
            'X-Request-Source' => 'internal-cron',
        ],
    ],
);
$api = new PasarGuard($client);
$users = $api->users->list(['limit' => 500]);
```

### 5. header سفارشی per-request (مثلاً، احراز هویت Telegram Mini App روی یک تماس واحد)

```php
$api->users->list(
    [], // بدون query
    [
        'X-Telegram-Init-Data' => '<init_data_string>',
        'X-Admin-Username'     => 'reseller_3',
    ]
);
```

---

## Error Handling

هر پاسخ غیر 2xx یک exception قابل پیش‌بینی واحد پرتاب می‌کند:

```php
use Pooshgan\PasarGuard\Exceptions\PasarGuardException;

try {
    $api->users->get('non_existent_user');
} catch (PasarGuardException $e) {
    echo $e->getMessage();        // "User not found" (جزئیات ارائه شده توسط سرور)
    echo $e->getCode();           // 404 (وضعیت HTTP)
    print_r($e->getErrorData());  // بدنه JSON decode شده کامل از سرور
}
```

| وضعیت HTTP | علت                                                   |
|-------------|---------------------------------------------------------|
| `400`       | Payload نادرست / خطای اعتبارسنجی                    |
| `401`       | bearer token گم شده یا نامعتبر                         |
| `403`       | احراز هویت شده اما مجاز نیست (نقش ناکافی)     |
| `404`       | Entity (کاربر / نود / هسته / ...) پیدا نشد             |
| `409`       | تضاد (مثلاً، username قبلاً گرفته شده)                 |
| `422`       | درخواست از نظر معنایی نامعتبر                            |
| `429`       | برخورد با محدودیت نرخ — عقب‌نشینی و تلاش مجدد                     |
| `5xx`       | خطای سمت سرور — با backoff نمایی تلاش مجدد      |

### مثال helper تلاش مجدد

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

### اشتراک‌گذاری یک نمونه SDK واحد در workerهای طولانی‌مدت

SDK در هر درخواست stateless است. می‌توانید یک نمونه `PasarGuard` را در bootstrap worker بسازید و آن را برای هزاران job مجدداً استفاده کنید:

```php
// bootstrap worker (RoadRunner / Swoole / FrankenPHP)
$api = new PasarGuard(new Client(/* ... */));

while ($job = $queue->consume()) {
    $api->users->resetDataUsage($job['username']);
}
```

### تزریق middlewareهای سفارشی Guzzle

از آنجایی که SDK هرگز Guzzle را پنهان نمی‌کند، می‌توانید با منتقل کردن یک نمونه از پیش ساخته شده `GuzzleClient` به یک زیرکلاس سفارشی `Client`، یا با دستکاری handler stack از طریق `guzzleOptions`، هر middlewareای را ضمیمه کنید. برای بیشتر موارد استفاده، گزینه‌های constructor کافی هستند:

```php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  '...',
    guzzleOptions: [
        'connect_timeout' => 5,
        'timeout'         => 30,
        'http_errors'     => false, // قبلاً به صورت پیش‌فرض false است
        'debug'           => fopen('php://stderr', 'w'),
    ],
);
```

### استفاده از چندین پنل به صورت همزمان

```php
$panelA = new PasarGuard(new Client('https://panel-a.example.com', $tokenA));
$panelB = new PasarGuard(new Client('https://panel-b.example.com', $tokenB));

$usersA = $panelA->users->list();
$usersB = $panelB->users->list();
```

### مسیر اشتراک غیر پیش‌فرض

```php
$client = new Client(
    baseUrl: 'https://panel.example.com',
    token:  '...',
    subscriptionPath: '/custom-sub',
);

$api = new PasarGuard($client);
$api->subscriptions->get('token'); // GET /custom-sub/token
```

### ارسال form params به جای JSON

بیشتر روش‌های mutating JSON ارسال می‌کنند. برای چند route که انتظار bodyهای form-encoded دارند (مثلاً، ورود ادمین)، SDK قبلاً از `form_params` استفاده می‌کند. برای موارد سفارشی، می‌توانید یک گزینه raw Guzzle `multipart` یا `form_params` را از طریق slotهای `headers` / `query` منتقل کنید — یا، تمیزتر، endpoint را گسترش دهید:

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
| `baseUrl`           | `string` | URL ریشه پنل، مثلاً `https://panel.example.com`. اسلش انتهایی trim می‌شود. |
| `token`             | `string` | Bearer token استفاده شده در header `Authorization`. |
| `subscriptionPath`  | `string` | پیشوند مسیر برای endpointهای اشتراک. پیش‌فرض `/sub`. |
| `guzzleOptions`     | `array`  | هر گزینه‌ای که توسط constructor `GuzzleHttp\Client` پذیرفته می‌شود (proxy، timeout، verify و غیره). |

#### `Client::request()`

```php
public function request(string $method, string $uri, array $options = []): array
```

یک درخواست HTTP انجام می‌دهد و payload JSON decode شده را به عنوان یک array برمی‌گرداند. در هر پاسخ غیر 2xx یک `PasarGuardException` پرتاب می‌کند.

### `PasarGuard`

یک facade که 15 نمونه endpoint را نگه می‌دارد. آن را با یک `Client` بسازید:

```php
public function __construct(Client $client)
```

### کنوانسیون‌های امضای روش Endpoint

هر روش endpoint یکی از سه شکل canonical را دنبال می‌کند:

```php
// Read (بدون body، query + headers اختیاری)
public function list(array $query = [], array $headers = []): array;

// Mutate (JSON body، query + headers اختیاری)
public function create(array $data = [], array $query = [], array $headers = []): array;

// Mutate با identifier
public function update(string $id, array $data = [], array $query = [], array $headers = []): array;
```

### `PasarGuardException`

```php
public function getMessage(): string;       // جزئیات ارائه شده توسط سرور
public function getCode(): int;             // کد وضعیت HTTP
public function getErrorData(): array;      // بدنه خطای JSON decode شده
```

---

## Credits

- **پنل اصلی**: [PasarGuard](https://github.com/PasarGuard/panel)
- **نویسنده SDK**: [Kazem Pooshgan](https://github.com/pooshgan)
- **پایه HTTP**: [GuzzleHTTP](https://github.com/guzzle/guzzle)

---

## License

این پروژه تحت [مجوز MIT](LICENSE) مجوز شده است.

Copyright (c) 2026 Kazem Pooshgan
