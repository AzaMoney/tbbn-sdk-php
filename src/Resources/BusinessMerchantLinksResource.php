<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * Links between a Business and the Merchants it runs.
 */
final class BusinessMerchantLinksResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(string $businessId, string $merchantId): mixed
    {
        return $this->client->request('POST', "/v1/businesses/{$businessId}/merchant-links", ['merchantId' => $merchantId]);
    }

    public function listForBusiness(string $businessId): mixed
    {
        return $this->client->request('GET', "/v1/businesses/{$businessId}/merchant-links");
    }

    public function revoke(string $businessId, string $linkId): mixed
    {
        return $this->client->request('POST', "/v1/businesses/{$businessId}/merchant-links/{$linkId}/revoke");
    }
}
