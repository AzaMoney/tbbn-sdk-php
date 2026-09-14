<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class ApiKeysResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(string $merchantId, string $environment, array $scopes, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/v1/api-keys', ['merchantId' => $merchantId, 'environment' => $environment, 'scopes' => $scopes], TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function list(string $merchantId): mixed
    {
        return $this->client->request('GET', "/v1/api-keys?merchantId={$merchantId}");
    }

    public function rotate(string $id, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', "/v1/api-keys/{$id}/rotate", null, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function revoke(string $id): mixed
    {
        return $this->client->request('DELETE', "/v1/api-keys/{$id}");
    }
}
