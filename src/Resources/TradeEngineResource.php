<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class TradeEngineResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function computeSettlement(array $input): mixed
    {
        return $this->client->request('POST', '/v1/trade-engine/settlement', $input);
    }
}
