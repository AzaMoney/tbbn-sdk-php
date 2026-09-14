<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class BillingResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function createSubscription(array $input): mixed
    {
        return $this->client->request('POST', '/v1/billing/subscriptions', $input);
    }

    public function getSubscription(string $merchantId): mixed
    {
        return $this->client->request('GET', "/v1/billing/subscriptions/{$merchantId}");
    }

    public function changeTier(string $merchantId, string $tier): mixed
    {
        return $this->client->request('POST', "/v1/billing/subscriptions/{$merchantId}/change-tier", ['tier' => $tier]);
    }

    public function cancelSubscription(string $merchantId): mixed
    {
        return $this->client->request('POST', "/v1/billing/subscriptions/{$merchantId}/cancel");
    }

    public function recordUsage(array $input): mixed
    {
        return $this->client->request('POST', '/v1/billing/usage', $input);
    }

    public function usageSummary(string $merchantId, ?string $billingPeriodRef = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/billing/usage/{$merchantId}", ['billingPeriodRef' => $billingPeriodRef]));
    }
}
