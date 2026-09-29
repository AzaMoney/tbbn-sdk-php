<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * Your merchant's OAuth clients for seller account linking.
 */
final class OAuthClientsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(string $merchantId, array $redirectUris, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/v1/oauth-clients', ['merchantId' => $merchantId, 'redirectUris' => $redirectUris], TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function list(string $merchantId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/oauth-clients', ['merchantId' => $merchantId]));
    }

    public function rotateSecret(string $id, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', "/v1/oauth-clients/{$id}/rotate-secret", null, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function revoke(string $id): mixed
    {
        return $this->client->request('DELETE', "/v1/oauth-clients/{$id}");
    }
}
