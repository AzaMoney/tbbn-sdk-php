<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class ListingsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function upsert(array $input, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', '/merchant/listings', $input, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function update(string $id, array $input, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('PUT', "/merchant/listings/{$id}", $input, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function remove(string $id): mixed
    {
        return $this->client->request('DELETE', "/merchant/listings/{$id}");
    }

    public function updateAvailability(string $id, string $status): mixed
    {
        return $this->client->request('POST', "/merchant/listings/{$id}/availability", ['status' => $status]);
    }

    public function replaceWants(string $id, array $wants): mixed
    {
        return $this->client->request('PUT', "/merchant/listings/{$id}/wants", ['wants' => $wants]);
    }

    public function getWants(string $id): mixed
    {
        return $this->client->request('GET', "/merchant/listings/{$id}/wants");
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/listings/{$id}");
    }

    public function list(array $query = []): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/listings', $query));
    }
}
