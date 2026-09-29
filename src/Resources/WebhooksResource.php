<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class WebhooksResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function createSubscription(array $input): mixed
    {
        return $this->client->request('POST', '/v1/webhooks/subscriptions', $input);
    }

    public function listSubscriptions(string $merchantId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/webhooks/subscriptions', ['merchantId' => $merchantId]));
    }

    /** Ownership comes from your credential. */
    public function disableSubscription(string $id): mixed
    {
        return $this->client->request('POST', "/v1/webhooks/subscriptions/{$id}/disable");
    }

    public function listDeliveries(string $subscriptionId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/webhooks/deliveries', ['subscriptionId' => $subscriptionId]));
    }

    public function replayDelivery(string $id): mixed
    {
        return $this->client->request('POST', "/v1/webhooks/deliveries/{$id}/replay");
    }

    /** Business (TBBN Space) webhooks — booking lifecycle events. ADMIN or DEVELOPER role. */
    public function createBusinessSubscription(string $businessId, string $url, array $events): mixed
    {
        return $this->client->request('POST', '/v1/webhooks/business-subscriptions', ['businessId' => $businessId, 'url' => $url, 'events' => $events]);
    }

    public function listBusinessSubscriptions(string $businessId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/webhooks/business-subscriptions', ['businessId' => $businessId]));
    }

    public function disableBusinessSubscription(string $id): mixed
    {
        return $this->client->request('POST', "/v1/webhooks/business-subscriptions/{$id}/disable");
    }

    public function listBusinessDeliveries(string $subscriptionId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/webhooks/business-deliveries', ['subscriptionId' => $subscriptionId]));
    }

    public function replayBusinessDelivery(string $id): mixed
    {
        return $this->client->request('POST', "/v1/webhooks/business-deliveries/{$id}/replay");
    }
}
