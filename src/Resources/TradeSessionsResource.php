<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class TradeSessionsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function list(string $sellerId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/trade-sessions', ['sellerId' => $sellerId]));
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/trade-sessions/{$id}");
    }

    public function cancel(string $id, string $actingSellerId, ?string $reason = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/cancel", ['actingSellerId' => $actingSellerId, 'reason' => $reason]);
    }
}
