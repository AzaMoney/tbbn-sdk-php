<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * TBBN's own plan and usage billing, per Business — never trade money. Every method takes a
 * Business id.
 */
final class BillingResource
{
    public function __construct(private readonly TbbnClient $client) {}

    /** Starts a plan (`businessId`, `billingEmail`, `tier`, optional `interval` MONTH/YEAR). A paid plan returns a Stripe Checkout `checkoutUrl`. */
    public function createSubscription(array $input): mixed
    {
        return $this->client->request('POST', '/v1/billing/subscriptions', $input);
    }

    public function getSubscription(string $businessId): mixed
    {
        return $this->client->request('GET', "/v1/billing/subscriptions/{$businessId}");
    }

    /** Whether service is paused (unpaid invoice or a usage balance below zero). */
    public function suspension(string $businessId): mixed
    {
        return $this->client->request('GET', "/v1/billing/subscriptions/{$businessId}/suspension");
    }

    /** Upgrade (charged now) or downgrade (at period end); `interval` is MONTH or YEAR. */
    public function changePlan(string $businessId, string $tier, ?string $interval = null): mixed
    {
        return $this->client->request('POST', "/v1/billing/subscriptions/{$businessId}/change-plan", ['tier' => $tier, 'interval' => $interval]);
    }

    public function changeTier(string $businessId, string $tier): mixed
    {
        return $this->client->request('POST', "/v1/billing/subscriptions/{$businessId}/change-tier", ['tier' => $tier]);
    }

    public function cancelSubscription(string $businessId): mixed
    {
        return $this->client->request('POST', "/v1/billing/subscriptions/{$businessId}/cancel");
    }

    /** Applies a finished Stripe Checkout (plan, top-up or card). Safe to call twice. */
    public function completeCheckout(string $sessionId): mixed
    {
        return $this->client->request('POST', '/v1/billing/checkout/complete', ['sessionId' => $sessionId]);
    }

    /** The usage balance, alarms, and this allowance window's usage per service. */
    public function wallet(string $businessId): mixed
    {
        return $this->client->request('GET', "/v1/billing/wallet/{$businessId}");
    }

    /** Adds to the usage balance (stays on the same plan). Returns a Checkout URL. */
    public function topUp(string $businessId, float $amountUsd): mixed
    {
        return $this->client->request('POST', "/v1/billing/wallet/{$businessId}/top-up", ['amountUsd' => $amountUsd]);
    }

    public function recordUsage(array $input): mixed
    {
        return $this->client->request('POST', '/v1/billing/usage', $input);
    }

    /** Your Merchant's plan (its Business's) and this period's usage: your own count of each service beside the Business's total and the plan's allowance. */
    public function merchantSummary(): mixed
    {
        return $this->client->request('GET', '/v1/billing/merchant/summary');
    }

    public function usageSummary(string $businessId, ?string $billingPeriodRef = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/billing/usage/{$businessId}", ['billingPeriodRef' => $billingPeriodRef]));
    }

    /** Where usage went — `groupBy` is day, merchant or eventType. */
    public function usageBreakdown(string $businessId, ?string $from = null, ?string $to = null, ?string $groupBy = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/billing/usage/{$businessId}/breakdown", ['from' => $from, 'to' => $to, 'groupBy' => $groupBy]));
    }

    public function statement(string $businessId, ?string $billingPeriodRef = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/billing/statements/{$businessId}", ['billingPeriodRef' => $billingPeriodRef]));
    }
}
