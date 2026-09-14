<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class SellersResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function verify(array $input, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/merchant/sellers/verify', $input, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function requestLinkOtp(string $linkRequestId): mixed
    {
        return $this->client->request('POST', '/v1/sellers/link/otp/request', ['linkRequestId' => $linkRequestId]);
    }

    public function verifyEmail(string $linkRequestId, string $code): mixed
    {
        return $this->client->request('POST', '/v1/sellers/link/otp/verify-email', ['linkRequestId' => $linkRequestId, 'code' => $code]);
    }

    public function verifyPhone(string $linkRequestId, string $code): mixed
    {
        return $this->client->request('POST', '/v1/sellers/link/otp/verify-phone', ['linkRequestId' => $linkRequestId, 'code' => $code]);
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/sellers/{$id}");
    }

    public function unlink(string $id, string $merchantId, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', "/v1/sellers/{$id}/unlink", ['merchantId' => $merchantId], TbbnClient::idempotencyHeader($idempotencyKey));
    }
}
