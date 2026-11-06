<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * Credit a store gives for a trade-in and spends on its own till. TBBN only keeps the record.
 */
final class TradeCreditsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function issue(array $input): mixed
    {
        return $this->client->request('POST', "/v1/trade_credits", $input);
    }

    public function list(): mixed
    {
        return $this->client->request('GET', "/v1/trade_credits");
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/trade_credits/{$id}");
    }

    public function redeem(string $id, array $input): mixed
    {
        return $this->client->request('POST', "/v1/trade_credits/{$id}/redeem", $input);
    }

    public function cancel(string $id): mixed
    {
        return $this->client->request('POST', "/v1/trade_credits/{$id}/void");
    }
}
