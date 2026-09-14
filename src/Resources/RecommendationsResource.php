<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class RecommendationsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function forSeller(string $sellerId, ?int $limit = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/recommendations/sellers/{$sellerId}", ['limit' => $limit]));
    }
}
