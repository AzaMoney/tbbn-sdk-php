> **This is a public read-only mirror.** The source of truth lives in `packages/sdk-php` of
> TBBN's private main repository; this mirror exists solely so Packagist's free tier (which
> resolves packages by fetching directly from a public VCS URL, not a decoupled artifact
> registry) can serve it. Content here is kept in sync automatically — don't open PRs directly
> against this repo.

# sdk-php (`tbbn/sdk` on Packagist)

**Status: WORKING (source only) — untested.** This folder is a plain PHP/Composer package, not
an npm package — it was never `@tbbn/sdk-php`; that naming only applies to the real npm packages
under `packages/sdk-*` (sdk-js, sdk-typescript, sdk-react, sdk-next, sdk-vue, sdk-rn). No PHP
toolchain exists in the environment this was written in, so this code has not been run — see
`.github/workflows/sdk-php-ci.yml` for the build-verification run once this is pushed. Written
as a faithful translation of `packages/sdk-js/src/client.ts`'s full method surface (all 27
resource groups, Phase 0-13). Review before shipping to production.

PHP 8.1+, PSR-4 autoloading (`Tbbn\Sdk\`). Uses the built-in `curl`/`json` extensions only — no
Guzzle dependency, so this SDK stays usable in any PHP 8.1+ project without a hard third-party
HTTP client requirement. Readonly properties/constructor promotion throughout (modern PHP 8.1
idiom).

```php
use Tbbn\Sdk\TbbnClient;

$client = new TbbnClient(baseUrl: 'https://sandbox-api.tbbnetwork.com', apiKey: 'sk_sandbox_...');

$offer = $client->offers->create([
    'fromSellerId' => '...',
    'toSellerId' => '...',
    'listingIdsA' => ['...'],
    'listingIdsB' => ['...'],
]);
```

Not yet published to Packagist — `composer require tbbn/sdk` once it is; for now, reference this
folder directly in `composer.json`'s `repositories`.

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
