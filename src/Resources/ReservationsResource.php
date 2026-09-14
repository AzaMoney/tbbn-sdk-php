<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class ReservationsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function lock(string $tradeSessionId): mixed
    {
        return $this->client->request('POST', '/v1/reservations', ['tradeSessionId' => $tradeSessionId]);
    }

    public function release(string $tradeSessionId): mixed
    {
        return $this->client->request('POST', '/v1/reservations/release', ['tradeSessionId' => $tradeSessionId]);
    }

    public function list(string $tradeSessionId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/reservations', ['tradeSessionId' => $tradeSessionId]));
    }
}
