<?php
// A minimal end-to-end walkthrough: publish a listing, look at incoming offers, and verify a
// webhook delivery. Run against the sandbox with a sandbox key:
//
//   TBBN_API_KEY=sk_sandbox_... TBBN_MERCHANT_ID=... TBBN_SELLER_ID=... php example/basic.php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Tbbn\Sdk\TbbnApiException;
use Tbbn\Sdk\TbbnClient;
use Tbbn\Sdk\WebhookVerifier;

$client = new TbbnClient(
    baseUrl: getenv('TBBN_API_BASE_URL') ?: 'https://api.tbbnetwork.com',
    apiKey: getenv('TBBN_API_KEY') ?: null,
);

try {
    // 1. Publish (or update) one of your seller's items. `merchantListingRef` is your own id for
    //    the item, so calling this again with the same ref updates rather than duplicates.
    $listing = $client->listings->upsert([
        'merchantId' => getenv('TBBN_MERCHANT_ID'),
        'merchantListingRef' => 'sku-1042',
        'sellerId' => getenv('TBBN_SELLER_ID'),
        'listingType' => 'BOTH',
        'title' => 'Nike Air Max 90 — size 10, lightly worn',
        'category' => 'Apparel',
        'subcategory' => 'Sneakers',
        'brand' => 'Nike',
        'condition' => 'Good',
        'originalPrice' => 150,
        'requestedAmount' => 25,
        'currency' => 'USD',
        'visibility' => 'GLOBAL',
        'wants' => [['category' => 'Electronics', 'subcategory' => 'Tablets']],
    ]);
    echo "Listing {$listing['id']} is live.\n";

    // 2. See what other sellers have offered for it.
    $offers = $client->offers->list($listing['sellerId'], 'received');
    echo count($offers) . " offer(s) waiting.\n";

    // 3. When a webhook arrives, verify it before trusting the payload. In a real handler, pass
    //    the raw request body (file_get_contents('php://input')) and the X-TBBN-Signature header.
    $ok = WebhookVerifier::verify(
        '{"type":"offer.created","data":{}}',
        't=1700000000,v1=deadbeef',
        'whsec_example',
        now: 1700000000,
    );
    echo 'Webhook signature valid: ' . ($ok ? 'true' : 'false') . "\n";
} catch (TbbnApiException $e) {
    fwrite(STDERR, "API error {$e->status} {$e->errorCode}: {$e->getMessage()} (request {$e->requestId})\n");
    exit(1);
}
