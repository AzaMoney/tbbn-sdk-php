<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class OffersResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(array $input): mixed
    {
        return $this->client->request('POST', '/v1/offers', $input);
    }

    public function list(string $sellerId, string $direction = 'all'): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/offers', ['sellerId' => $sellerId, 'direction' => $direction]));
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/offers/{$id}");
    }

    public function accept(string $id, string $actingSellerId): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/accept", ['actingSellerId' => $actingSellerId]);
    }

    public function reject(string $id, string $actingSellerId): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/reject", ['actingSellerId' => $actingSellerId]);
    }

    public function cancel(string $id, string $actingSellerId): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/cancel", ['actingSellerId' => $actingSellerId]);
    }

    public function counter(string $id, array $input): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/counter", $input);
    }
}
