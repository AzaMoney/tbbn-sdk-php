<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * 1–5 star reviews, earned by a completed trade or Space booking.
 */
final class ReviewsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(array $input): mixed
    {
        return $this->client->request('POST', '/v1/reputation/reviews', $input);
    }

    public function forMerchant(string $merchantId): mixed
    {
        return $this->client->request('GET', "/v1/reputation/merchants/{$merchantId}/reviews");
    }

    public function forBranch(string $branchId): mixed
    {
        return $this->client->request('GET', "/v1/reputation/branches/{$branchId}/reviews");
    }
}
