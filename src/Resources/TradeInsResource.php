<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * An item accepted at the counter becomes your listing at that location.
 */
final class TradeInsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function accept(array $input): mixed
    {
        return $this->client->request('POST', "/v1/trade_ins", $input);
    }
}
