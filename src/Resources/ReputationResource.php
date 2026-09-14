<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class ReputationResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function getScore(string $sellerId): mixed
    {
        return $this->client->request('GET', "/v1/reputation/sellers/{$sellerId}");
    }
}
