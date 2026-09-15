> **This is a public read-only mirror.** The source of truth lives in `packages/sdk-php` of
> TBBN's private main repository; this mirror exists solely so Packagist's free tier (which
> resolves packages by fetching directly from a public VCS URL, not a decoupled artifact
> registry) can serve it. Content here is kept in sync automatically — don't open PRs directly
> against this repo.

# tbbn/sdk

PHP client for the [TBBN Platform API](https://developer.tbbnetwork.com). Publish listings, manage offers and trade
sessions, and verify webhooks. PHP 8.1+, PSR-4, uses the built-in `curl` and `json`
extensions only — no HTTP-client dependency.

## Install

```bash
composer require tbbn/sdk
```

## Quick start

```php
use Tbbn\Sdk\TbbnClient;

$client = new TbbnClient(baseUrl: 'https://api.tbbnetwork.com', apiKey: 'sk_sandbox_...');

$listing = $client->listings->upsert([
    'merchantId' => '...',
    'merchantListingRef' => 'sku-1042',
    'sellerId' => '...',
    'listingType' => 'BOTH',
    'title' => 'Nike Air Max 90 — size 10, lightly worn',
    'category' => 'Apparel',
    'originalPrice' => 150,
    'requestedAmount' => 25,
    'currency' => 'USD',
    'visibility' => 'GLOBAL',
]);

$offers = $client->offers->list($listing['sellerId'], 'received');
```

A complete runnable walkthrough is in [`example/basic.php`](./example/basic.php).

## Authentication

Pass either an **API key** (`apiKey`, issued to your merchant at
[merchants.tbbnetwork.com](https://merchants.tbbnetwork.com)) or a **session token**
(`accessToken`, obtained through one of the `auth` sign-in flows). Sandbox keys
(`sk_sandbox_…`) work against the same API and never touch live data.

## Webhooks

Verify every inbound delivery before trusting it. Pass the raw request body exactly as
received — re-serialising the JSON changes the bytes and the signature will not match.
Signatures are HMAC-SHA256 with a five-minute replay window.

```php
use Tbbn\Sdk\WebhookVerifier;

$ok = WebhookVerifier::verify($rawBody, $_SERVER['HTTP_X_TBBN_SIGNATURE'], $signingSecret);
```

## Errors

Every non-2xx response throws `TbbnApiException` with `status`, `errorCode`, `requestId`, and the message. Quote the request id when asking
for help with a specific call.

## Resources

`auth`, `merchants`, `apiKeys`, `sellers`, `listings`, `catalog`, `media`, `directory`, `search`, `tradeEngine`, `currency`, `localization`, `matching`, `recommendations`, `offers`, `tradeSessions`, `checkout`, `billing`, `notifications`, `webhooks`, `auditLogs`, `moderation`, `fraud`, `reputation`, `analytics`, `features`, `sandbox`. Each method maps one-to-one onto an API endpoint documented in the
[API reference](https://developer.tbbnetwork.com/merchant/docs/api).

## Support

Questions and bug reports: the [developer community](https://developer.tbbnetwork.com/community).

## License

MIT © Trade By Barter Network, Inc.
