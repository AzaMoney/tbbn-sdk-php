> **This is a public read-only mirror.** The source of truth lives in `packages/sdk-php` of
> TBBN's private main repository; this mirror exists solely so Packagist's free tier (which
> resolves packages by fetching directly from a public VCS URL, not a decoupled artifact
> registry) can serve it. Content here is kept in sync automatically — don't open PRs directly
> against this repo.

# sdk-php (`tbbn/sdk` on Packagist)

**Status: WORKING — build-verified via CI** (which caught a real bug: `TbbnApiException`'s
`$code` property collided with PHP's built-in `\Exception::$code`, fixed by renaming to
`$errorCode`). This folder is a plain PHP/Composer package, not an npm package — it was never
`@tbbn/sdk-php`; that naming only applies to the real npm packages under `packages/sdk-*`
(sdk-js, sdk-typescript, sdk-react, sdk-next, sdk-vue, sdk-rn). No PHP toolchain exists in this
dev environment, so `.github/workflows/sdk-php-ci.yml` is the only place this has ever actually
been parsed/linted. Written as a faithful translation of `packages/sdk-js/src/client.ts`'s full
method surface (all 27 resource groups, Phase 0-13).

PHP 8.1+, PSR-4 autoloading (`Tbbn\Sdk\`). Uses the built-in `curl`/`json` extensions only — no
Guzzle dependency, so this SDK stays usable in any PHP 8.1+ project without a hard third-party
HTTP client requirement. Readonly properties/constructor promotion throughout (modern PHP 8.1
idiom).

```php
use Tbbn\Sdk\TbbnClient;

$client = new TbbnClient(baseUrl: 'https://api.tbbnetwork.com', apiKey: 'sk_sandbox_...');

$offer = $client->offers->create([
    'fromSellerId' => '...',
    'toSellerId' => '...',
    'listingIdsA' => ['...'],
    'listingIdsB' => ['...'],
]);
```

## Installing

```bash
composer require tbbn/sdk
```

Free Packagist resolves packages by fetching directly from a public VCS URL — there's no
decoupled artifact registry the way npm/Maven Central/PyPI work. Since TBBN's main repository is
private, [`AzaMoney/tbbn-sdk-php`](https://github.com/AzaMoney/tbbn-sdk-php) is a small **public**
mirror containing only this folder's source, kept in sync automatically by
`.github/workflows/mirror-sdk-php.yml` whenever this folder changes on `master`, and is the VCS
URL Packagist actually points at. Cutting a new consumer-facing version is a separate, manual
step (tag the mirror repo directly) — the mirror's main branch always reflects the latest
source, but existing tags never move.

## Webhook signature verification

```php
use Tbbn\Sdk\WebhookVerifier;

$isValid = WebhookVerifier::verify($rawBody, $_SERVER['HTTP_X_TBBN_SIGNATURE'], $signingSecret);
```

## Coverage

`auth`, `merchants`, `apiKeys`, `sellers`, `listings`, `catalog`, `media`, `directory`,
`search`, `tradeEngine`, `currency`, `localization`, `matching`, `recommendations`, `offers`,
`reservations`, `tradeSessions`, `checkout`, `billing`, `notifications`, `webhooks`,
`auditLogs`, `moderation`, `fraud`, `reputation`, `analytics`, `features`, `sandbox` — every
resource group `sdk-js` exposes, one class per group under `src/Resources/`.
