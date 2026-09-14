<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class MatchingResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function candidates(string $listingId, ?int $limit = null): mixed
    {
        return $this->client->request('POST', '/v1/matching/candidates', ['listingId' => $listingId, 'limit' => $limit]);
    }

    public function score(string $listingIdA, string $listingIdB): mixed
    {
        return $this->client->request('POST', '/v1/matching/score', ['listingIdA' => $listingIdA, 'listingIdB' => $listingIdB]);
    }
}
