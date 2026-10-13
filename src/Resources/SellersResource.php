<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class SellersResource
{
    public function __construct(private readonly TbbnClient $client) {}

    /** Verifies (or creates) a seller for your reference. To link an existing TBBN member, use the OAuth flow in `oauthLink`. */
    public function verify(array $input, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/merchant/sellers/verify', $input, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    /** A trade participant your platform tracks without a TBBN account (Growth and above). */
    public function createHeadless(string $merchantId, string $merchantSellerRef, ?string $name = null, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/merchant/sellers/headless', ['merchantId' => $merchantId, 'merchantSellerRef' => $merchantSellerRef, 'name' => $name], TbbnClient::idempotencyHeader($idempotencyKey));
    }

    /** Redeem a customer's TBBN link code, naming your own reference for them (optional). */
    public function redeemLinkCode(string $code, ?string $merchantSellerRef = null, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/merchant/sellers/link-code', ['code' => $code, 'merchant_seller_ref' => $merchantSellerRef], TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/sellers/{$id}");
    }

    public function listForMerchant(string $merchantId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/sellers', ['merchantId' => $merchantId]));
    }

    public function unlink(string $id, string $merchantId, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', "/v1/sellers/{$id}/unlink", ['merchantId' => $merchantId], TbbnClient::idempotencyHeader($idempotencyKey));
    }
}
